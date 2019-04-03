<?php

namespace RiotQuest\Components\Framework\Engine;

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

    /**
     * The HTTP method for this request
     *
     * @var string
     */
    public $method;

    /**
     * The request URL
     *
     * @var string
     */
    public $destination;

    /**
     * The JSON payload for this request
     *
     * @var array
     */
    public $payload;

    /**
     * Arguments to supply for the destination URL
     *
     * @var array
     */
    public $arguments;

    /**
     * Key to use: STANDARD | TOURNAMENT
     *
     * @var string
     */
    public $key;

    /**
     * The class and function which invoked this request
     *
     * @var array
     */
    public $parent;

    /**
     * Seconds for the item to live in cache if its fetched from API
     *
     * @var int
     */
    public $ttl;

    /**
     * Tell request to use standard API key
     *
     * @return $this
     */
    public function useStandard(): self
    {
        $this->key = 'STANDARD';
        return $this;
    }

    /**
     * Tell request to use tournament API key
     *
     * @return $this
     */
    public function useTournament(): self
    {
        $this->key = 'TOURNAMENT';
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
        $me->parent = $parent;
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
        $this->payload = $payload;
        return $this;
    }

    /**
     * @param int $ttl
     * @return $this
     */
    public function setTtl(int $ttl): self
    {
        $this->ttl = $ttl;
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
        $this->method = $method;
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
        $this->destination = $destination;
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
        $this->arguments = $arguments;
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
        if (!($this->arguments['region'] = Library::resolveRegion($this->arguments['region']))) {
            throw new RiotQuestException('ERROR: Specified region could not be resolved.');
        }
        $this->destination = Library::replace($this->destination, $this->arguments);
        return $this;
    }

    /**
     * Turns url into a cache key
     *
     * @return string
     */
    public function getKey(): string
    {
        $str = "riotquest." . $this->parent[0] . '.' . $this->parent[1] . '?';
        foreach ($this->arguments as $k => $v) {
            $str .= "$k=$v,";
        }
        return trim($str, ',');
    }

    /**
     * Send the http request and return a response
     *
     * @return mixed
     * @throws RiotQuestException
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Psr\SimpleCache\InvalidArgumentException
     * @throws \ReflectionException
     */
    public function sendRequest()
    {
        if (Client::getCache('request')->has($this->getKey())) {
            return $this->completeRequest(json_decode(Client::getCache('request')->get($this->getKey()), 1));
        } else if (Client::isHittable($this->arguments['region'], $this->parent[0] . '.' . $this->parent[1], strtolower($this->key))) {
            $client = new HttpClient();
            $response = $client->request($this->method, $this->destination, [
                'body' => json_encode($this->payload),
                'headers' => [
                    'Content-Type' => 'application/json',
                    'X-Riot-Token' => Client::getKeys()[$this->key]->getKey()
                ],
                'http_errors' => false
            ]);

            return $this->completeRequest($response);
        }
        throw new RiotQuestException('Rate Limit would be exceeded by making this call');
    }


    /**
     * Turns a api cache response or guzzle response into a
     * collection or throws an exception if an error was met
     *
     * @param $response
     * @return mixed
     * @throws RiotQuestException
     * @throws \Psr\SimpleCache\InvalidArgumentException
     */
    public function completeRequest($response)
    {
        $ref = Library::$returnTypes[$this->parent[0]][$this->parent[1]];
        if ($response instanceof \GuzzleHttp\Psr7\Response) {
            if ($response->getStatusCode() == 200) {
                $limits = $response->getHeaders()['X-Method-Rate-Limit'][0];
                Client::registerHit(
                    $this->arguments['region'],
                    $this->parent[0] . '.' . $this->parent[1],
                    strtolower($this->key),
                    explode(':', $limits)
                );

                $load = (array)json_decode($response->getBody()->getContents(), 1);
                Client::getCache('request')->set($this->getKey(), json_encode($load), $this->ttl);
                // If request is not from command line
                if ($ref && RIOTQUEST_ENV === 'API') {
                    $template = strtolower(array_reverse(explode('\\', $ref))[0]) . '.json';
                    return Library::traverse($load, Library::loadTemplate($template), $this->arguments['region']);
                } else {
                    return $load;
                }
            } else {
                throw new RiotQuestException(json_decode($response->getBody()->getContents(), 1)['status']['message'], $response->getStatusCode());
            }
        } else {
            // If request is not from command line
            if ($ref && RIOTQUEST_ENV === 'API') {
                return Library::traverse($response, Library::template($ref), $this->arguments['region']);
            } else if (RIOTQUEST_ENV === 'CLI') {
                return $response;
            }
            return $response[0];
        }
    }


}
