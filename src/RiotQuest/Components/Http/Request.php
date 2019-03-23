<?php

namespace RiotQuest\Components\Http;

use RiotQuest\Support\Helpers\League;
use RiotQuest\Support\Str;
use RiotQuest\Contracts\RiotQuestException;
use RiotQuest\Components\Riot\Client\Client;
use GuzzleHttp\Client as HttpClient;

/**
 * Class Request
 *
 * Definition to send HTTP request to the
 * Riot Games API
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
     * Key to use: STANDARD | TORUNAMENT
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
     * Tell request to use standard API key
     *
     * @return $this
     */
    public function useStandard()
    {
        $this->key = 'STANDARD';
        return $this;
    }

    /**
     * Tell request to use tournament API key
     *
     * @return $this
     */
    public function useTournament()
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
    public function make($parent)
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
    public function setPayload($payload)
    {
        $this->payload = $payload;
        return $this;
    }

    /**
     * Set the HTTP method
     *
     * @param $method
     * @return $this
     */
    public function setMethod($method)
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
    public function setDestination($destination)
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
    public function setArguments($arguments)
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
    public function compile()
    {
        if (!($this->arguments['region'] = League::region($this->arguments['region']))) {
            throw new RiotQuestException('ERROR: Specificed region could not be resolved.');
        }
        $this->destination = Str::replace($this->destination, $this->arguments);
        return $this;
    }

    /**
     * Send the http request and return a response
     *
     * @return Response
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws RiotQuestException
     */
    public function send()
    {
        if (Client::available($this->arguments['region'], $this->parent[0] . '.' . $this->parent[1])) {
            $client = new HttpClient();

            $response = $client->request($this->method, $this->destination, [
                'body' => json_encode($this->payload),
                'headers' => [
                    'Content-Type' => 'application/json',
                    'X-Riot-Token' => Client::getKeys()[$this->key]->getKey()
                ],
                'http_errors' => false
            ]);

            return new Response($this, $response);
        }
        throw new RiotQuestException('Rate Limit would be exceeded by making this call');
    }

}
