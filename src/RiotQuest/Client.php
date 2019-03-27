<?php

namespace RiotQuest;

use RiotQuest\Components\Framework\Client\Token;
use RiotQuest\Components\Framework\Client\Client as Module;

/**
 * Class Client
 *
 * Static accessor for the entire Client API
 * Provies helper method to essential usages
 * for the API.
 *
 * TODO: cache templates for collections
 * TODO: unit tests
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
    public static function token($token, $type, $limit): Token
    {
        return new Token($token, $type, $limit);
    }
}
