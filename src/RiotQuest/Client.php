<?php

namespace RiotQuest;

use RiotQuest\Components\Riot\Client\Token;
use RiotQuest\Components\Riot\Client\Client as Module;

/**
 * Class Client
 *
 * Static accessor for the entire Client API
 * Provies helper method to essential usages
 * for the API.
 *
 * @package RiotQuest\Support\Facades
 */
class Client extends Module
{

    /**
     * New API key
     *
     * @param $token
     * @param $type
     * @param $limit
     * @return Token
     */
    public static function token($token, $type, $limit)
    {
        return new Token($token, $type, $limit);
    }
}
