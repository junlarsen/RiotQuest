<?php

namespace RiotQuest\Contracts;

interface RateLimit
{

    public static function hit($region, $endpoint = null);

    public static function available($region, $endpoint = null);

}
