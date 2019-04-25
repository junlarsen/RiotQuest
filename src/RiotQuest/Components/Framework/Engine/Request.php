<?php

namespace RiotQuest\Components\Framework\Engine;

use RiotQuest\Contracts\APIException;
use RiotQuest\Contracts\LeagueException;
use RiotQuest\Components\Framework\Client\Client;
use GuzzleHttp\Client as HttpClient;
use RiotQuest\Contracts\ParameterException;

/**
 * Class Request
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
    public function setTtl(int $ttl): self
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
    public function compile()
    {
        if (!($this->vars['region'] = $this->vars['args']['region'] = Library::resolveRegion($this->vars['args']['region']))) {
            throw new ParameterException('ERROR: Specified region could not be resolved.');
        }
        $this->vars['url'] = Library::replace($this->vars['dest'], $this->vars['args']);
        return $this;
    }

    /**
     * Sends the request which has been produced
     *
     * @return array|mixed
     * @throws LeagueException
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Psr\SimpleCache\InvalidArgumentException
     */
    public function sendRequest()
    {
        if (Client::getCache('request')->has($this->vars['url']) && $this->vars['ttl'] !== false) {
            return $this->completeFromCache($this->vars);
        } else {
            return $this->completeFromApi($this->vars);
        }
    }

    /**
     * Complete a request by pulling it from the cache
     *
     * @param $request
     * @return mixed
     * @throws \Psr\SimpleCache\InvalidArgumentException
     * @throws LeagueException
     */
    private function completeFromCache(array $request)
    {
        $collection = Library::$returnTypes[$request['keys'][0]][$request['keys'][1]];
        $items = json_decode(Client::getCache('request')->get($request['url']), 1);
        return ($collection && RIOTQUEST_ENV === 'API')
            ? Library::traverse($items, Library::loadTemplate($collection), $request['region'])
            : (($collection)
                ? $items
                : $items[0] ?? null);
    }

    /**
     * Completes a request by pulling it from the API and caching it
     *
     * @param $request
     * @return array|mixed
     * @throws LeagueException
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Psr\SimpleCache\InvalidArgumentException
     */
    private function completeFromApi(array $request)
    {
        if (Client::isHittable($request['region'], $request['name'], $request['use'])) {
            $response = (new HttpClient())->request($request['method'], $request['url'],
                [
                    'body' => json_encode($request['body'] ?? null),
                    'headers' => [
                        'Content-Type' => 'application/json',
                        'X-Riot-Token' => Client::getKeys()[$request['use']]->getKey()
                    ],
                    'http_errors' => false
                ]
            );
            Client::registerHit($request['region'], $request['name'], $request['use'], explode(':', $response->getHeader('X-Method-Rate-Limit')[0]));

            // Work with the response
            $items = (array)json_decode($response->getBody()->getContents(), 1);
            if ($response->getStatusCode() >= 300 && !in_array($request['name'], Client::$config['HTTP_ERROR_EXCEPT'])) {
                throw new APIException("API Error! Status Code:" . $response->getStatusCode(), $response->getStatusCode(), null, $items);
            }

            // using true switch here to match multiple cases
            // TODO: add more fallbacks
            switch (true) {
                // if item should be cached
                case (!in_array($request['name'], Client::$config['FORCE_CACHE_NONE'])):
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
     * @param $request
     * @param $load
     * @throws \Psr\SimpleCache\InvalidArgumentException
     * @throws LeagueException
     */
    private function saveToCache(array $request, $load)
    {
        in_array($request['name'], Client::$config['FORCE_CACHE_PERMANENT'])
            ? Client::getCache('request')->set($request['url'], json_encode($load))
            : Client::getCache('request')->set($request['url'], json_encode($load), $request['ttl']);
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
        return ($collection && RIOTQUEST_ENV === 'API')
            ? Library::traverse($load, Library::loadTemplate($collection), $request['region'])
            : (($collection)
                ? $load
                : $load[0] ?? null);
    }

}
