<?php

namespace RiotQuest\Support\Facades;

use RiotQuest\Components\Riot\Client\Client as Module;
use RiotQuest\Components\Riot\Client\Token;

class Client extends Module
{

    public static function token($token, $type)
    {
        return new Token($token, $type);
    }


}
