<?php

namespace RiotQuest\Contracts;

/**
 * Interface RateLimit
 *
 * Interface for anything that controls a rate limit.
 *
 * You should be able to register a hit on an endpoint
 * and be able to check if you can hit an endpoint again.
 *
 * @package RiotQuest\Contracts
 */
interface RateLimit
{

    /**
     * Register that you've hit an endpoint
     *
     * @param $region
     * @param null $endpoint
     * @return mixed
     */
    public static function hit($region, $endpoint = null);

    /**
     * Test whether you're able to hit an endpoint
     *
     * @param $region
     * @param null $endpoint
     * @return mixed
     */
    public static function available($region, $endpoint = null);

}
