<?php

namespace RiotQuest\Components\Client;

/**
 * Class Token
 *
 * Definition for an API key class
 *
 * @package RiotQuest\Components\Riot\Client
 */
class Token
{

    /**
     * The raw API key
     */
    private string $key;

    /**
     * The key type: STANDARD | TOURNAMENT
     */
    private string $type;

    /**
     * Create a new API key
     *
     * @param $key
     * @param $type
     */
    public function __construct(string $key, string $type)
    {
        $this->type = $type;
        $this->key = $key;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @return string
     */
    public function getKey(): string
    {
        return $this->key;
    }

}
