<?php

namespace RiotQuest\Components\Framework\Engine;

use RiotQuest\Components\Framework\Cache\CacheModel;
use RiotQuest\Contracts\RiotQuestException;
use RiotQuest\Components\Framework\Client\Client;
use RiotQuest\Components\Framework\Engine\Library;
use GuzzleHttp\Client as HttpClient;

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
    public static function make($parent): self
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
    public function setMethod($method): self
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
    public function setDestination($destination): self
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
    public function setArguments($arguments): self
    {
        $this->vars['args'] = $arguments;
        return $this;
    }

    /**
     * Build the request from its own properties
     *
     * @return $this
     * @throws RiotQuestException
     */
    public function compile(): self
    {
        if (!($this->vars['region'] = $this->vars['args']['region'] = Library::resolveRegion($this->vars['args']['region']))) {
            throw new RiotQuestException('ERROR: Specified region could not be resolved.');
        }
        $this->vars['url'] = Library::replace($this->vars['dest'], $this->vars['args']);
        return $this;
    }

    /**
     * Sends the request which has been produced
     *
     * @return array|mixed
     * @throws RiotQuestException
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Psr\SimpleCache\InvalidArgumentException
     */
    public function sendRequest()
    {
        if (Client::getCache('request')->has($this->vars['url'])) {
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
     */
    private function completeFromCache($request)
    {
        $collection = Library::$returnTypes[$request['keys'][0]][$request['keys'][1]];
        $items = json_decode(Client::getCache('request')->get($request['url']), 1);
        return ($collection && RIOTQUEST_ENV === 'API')
            ? Library::traverse($items, Library::loadTemplate($collection), $request['region'])
            : $items;
    }

    /**
     * Completes a request by pulling it from the API and caching it
     *
     * @param $request
     * @return array|mixed
     * @throws RiotQuestException
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Psr\SimpleCache\InvalidArgumentException
     */
    private function completeFromApi($request)
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
            $collection = Library::$returnTypes[$request['keys'][0]][$request['keys'][1]];
            Client::registerHit($request['region'], $request['name'], $request['use'], explode(':', $response->getHeader('X-Method-Rate-Limit')[0]));
            $items = (array) json_decode($response->getBody()->getContents(), 1);
            Client::getCache('request')->set($request['url'], json_encode($items), $request['ttl']);
            return ($collection && RIOTQUEST_ENV === 'API')
                ? Library::traverse($items, Library::loadTemplate($collection), $request['region'])
                : $items;

        } else {
            throw new RiotQuestException("Rate Limit would be exceeded by making this call.");
        }
    }

}
