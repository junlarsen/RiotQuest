<?php

namespace RiotQuest\Components\RateLimit;

use RiotQuest\Contracts\RateLimit;

class Endpoint implements RateLimit
{

    protected static $limits = [];

    protected static $cache;

    public static function enable()
    {

    }

    public static function available($region, $endpoint = null)
    {

    }

    public static function hit($region, $endpoint = null)
    {

    }

}
