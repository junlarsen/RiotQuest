<?php

namespace RiotQuest\Components\Framework\Engine;

use GuzzleHttp\Client as HttpClient;
use GuzzleHttp\Exception\GuzzleException;
use League\Flysystem\FileExistsException;
use League\Flysystem\FileNotFoundException;
use Psr\SimpleCache\InvalidArgumentException;
use RiotQuest\Components\Framework\Client\Application;
use RiotQuest\Contracts\APIException;
use RiotQuest\Contracts\LeagueException;

/**
 * Class RequestCache
 *
 * Definition to send HTTP request to the
 * Riot Games API
 *
 * Uses a sort-of query builder to make a nice
 * method-chaining API to build requests
 *
 * @package RiotQuest\Components\Http
 */
class Request
{

    private $vars = [];

    /**
     * Tell request to use standard API key
     *
     * @return $this
     */
    public function useStandard(): self
    {
        $this->vars['use'] = 'STANDARD';
        return $this;
    }

    /**
     * Tell request to use tournament API key
     *
     * @return $this
     */
    public function useTournament(): self
    {
        $this->vars['use'] = 'TOURNAMENT';
        return $this;
    }

    /**
     * Statically make a new request builder
     *
     * @param $parent
     * @return Request
     */
    public static function make(array $parent): self
    {
        $me = new static;
        $me->vars['name'] = implode('.', $parent);
        $me->vars['keys'] = $parent;
        return $me;
    }

    /**
     * Set the request payload
     *
     * @param $payload
     * @return $this
     */
    public function setPayload($payload): self
    {
        $this->vars['body'] = $payload;
        return $this;
    }

    /**
     * @param int $ttl
     * @return $this
     */
    public function setTtl($ttl): self
    {
        $this->vars['ttl'] = $ttl;
        return $this;
    }

    /**
     * Set the HTTP method
     *
     * @param $method
     * @return $this
     */
    public function setMethod(string $method): self
    {
        $this->vars['method'] = $method;
        return $this;
    }

    /**
     * Set destination URL
     *
     * @param $destination
     * @return $this
     */
    public function setDestination(string $destination): self
    {
        $this->vars['dest'] = $destination;
        return $this;
    }

    /**
     * Set the supplements for the destination URL
     *
     * @param $arguments
     * @return $this
     */
    public function setArguments(array $arguments = []): self
    {
        $this->vars['args'] = $arguments;
        return $this;
    }

    /**
     * Build the request from its own properties
     *
     * @return $this
     * @throws LeagueException
     */
    public function compile(): self
    {
        if (!($this->vars['region'] = $this->vars['args']['region'] = Library::resolveRegion($this->vars['args']['region']))) {
            throw new LeagueException('ERROR: Specified region could not be resolved.');
        }
        $this->vars['url'] = Library::replace($this->vars['dest'], $this->vars['args']);
        return $this;
    }

    /**
     * Sends the request which has been produced
     *
     * @return array|mixed
     * @throws LeagueException
     * @throws GuzzleException
     * @throws FileNotFoundException
     * @throws InvalidArgumentException
     */
    public function sendRequest()
    {
        if (Application::getInstance()->getCache('request')->has($this->vars['url']) && $this->vars['ttl'] !== false) {
            return $this->completeFromCache($this->vars);
        } else {
            return $this->completeFromApi($this->vars);
        }
    }

    /**
     * Complete a request by pulling it from the cache
     *
     * @param array $request
     * @return mixed|null
     * @throws LeagueException
     * @throws FileNotFoundException
     */
    private function completeFromCache(array $request)
    {
        $collection = Library::$returnTypes[$request['keys'][0]][$request['keys'][1]];
        $items = json_decode(Application::getInstance()->getCache('request')->get($request['url']), 1);

        if ($collection) {
            return Library::traverse($items, Library::loadTemplate($collection), $request['region']);
        }

        return $collection ? $items : ($items[0] ?? null);
    }

    /**
     * Completes a request by pulling it from the API and caching it
     *
     * @param array $request
     * @return mixed|null
     * @throws APIException
     * @throws LeagueException
     * @throws GuzzleException
     * @throws FileExistsException
     * @throws FileNotFoundException
     * @throws InvalidArgumentException
     */
    private function completeFromApi(array $request)
    {
        if (Application::getInstance()->hittable($request['region'], $request['name'], $request['use'])) {
            $response = (new HttpClient())->request($request['method'], $request['url'],
                [
                    'body' => json_encode($request['body'] ?? null),
                    'headers' => [
                        'Content-Type' => 'application/json',
                        'X-Riot-Token' => Application::getInstance()->getKeys()[$request['use']]->getKey()
                    ],
                    'http_errors' => false
                ]
            );
            /** @noinspection PhpParamsInspection */
            Application::getInstance()->register($request['region'], $request['name'], $request['use'], explode(':', $response->getHeader('X-Method-Rate-Limit')[0]));

            // Work with the response
            $items = (array)json_decode($response->getBody()->getContents(), 1);
            if ($response->getStatusCode() >= 300 && !in_array($request['name'], Application::$rules['HTTP_ERROR_EXCEPT'])) {
                throw new APIException("API Error! Status Code:" . $response->getStatusCode(), $response->getStatusCode(), null, $items);
            }

            // using true switch here to match multiple cases
            // can add more fall backs to this later
            switch (true) {
                // if item should be cached
                case (!in_array($request['name'], Application::$rules['FORCE_CACHE_NONE'])):
                    $this->saveToCache($request, $items);

            }

            return $this->finalize($request, $items);
        } else {
            throw new APIException("Rate Limit would be exceeded by making this call.");
        }
    }

    /**
     * Save an item to the cache, whether the request resides permanently in cache or not
     *
     * @param array $request
     * @param $load
     * @throws LeagueException
     * @throws FileExistsException
     * @throws FileNotFoundException
     */
    private function saveToCache(array $request, $load)
    {
        in_array($request['name'], Application::$rules['FORCE_CACHE_PERMANENT'])
            ? Application::getInstance()->getCache('request')->set($request['url'], json_encode($load))
            : Application::getInstance()->getCache('request')->set($request['url'], json_encode($load), $request['ttl']);
    }

    /**
     * Finalize the response
     *
     * @param $request
     * @param $load
     * @return mixed|null
     */
    private function finalize(array $request, $load)
    {
        $collection = Library::$returnTypes[$request['keys'][0]][$request['keys'][1]];

        if ($collection) {
            return Library::traverse($load, Library::loadTemplate($collection), $request['region']);
        }

        return $collection ? $load : ($load[0] ?? null);
    }

}
