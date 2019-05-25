<?php

namespace RiotQuest\Components\Framework\Client;

use RiotQuest\Components\Framework\Endpoints\Champion;
use RiotQuest\Components\Framework\Endpoints\Code;
use RiotQuest\Components\Framework\Endpoints\League;
use RiotQuest\Components\Framework\Endpoints\Mastery;
use RiotQuest\Components\Framework\Endpoints\Match;
use RiotQuest\Components\Framework\Endpoints\Spectator;
use RiotQuest\Components\Framework\Endpoints\Status;
use RiotQuest\Components\Framework\Endpoints\Summoner;
use RiotQuest\Contracts\LeagueException;

/**
 * Class Client
 *
 * The entire RiotQuest Framework is bundled into
 * this static class.
 *
 * @package RiotQuest\Components\Riot\Client
 */
class Client
{

    public static function boot() {
        Application::load();
    }

    /**
     * Access Champion V3 endpoints
     *
     * @param $region
     * @param int $ttl
     * @return Champion
     */
    public static function champion(string $region, $ttl = 3600)
    {
        return new Champion($region, $ttl);
    }

    /**
     * Access Champion Mastery V4 endpoints
     *
     * @param $region
     * @param int $ttl
     * @return Mastery
     */
    public static function mastery(string $region, $ttl = 3600)
    {
        return new Mastery($region, $ttl);
    }

    /**
     * Access League V4 endpoints
     *
     * @param $region
     * @param int $ttl
     * @return League
     */
    public static function league(string $region, $ttl = 3600)
    {
        return new League($region, $ttl);
    }

    /**
     * Access LOL Status V3 endpoints
     *
     * @param $region
     * @param int $ttl
     * @return Status
     */
    public static function status(string $region, $ttl = 3600)
    {
        return new Status($region, $ttl);
    }

    /**
     * Access Match V4 endpoints
     *
     * @param $region
     * @param int $ttl
     * @return Match
     */
    public static function match(string $region, $ttl = 3600)
    {
        return new Match($region, $ttl);
    }

    /**
     * Access Spectator V4 endpoints
     *
     * @param $region
     * @param int $ttl
     * @return Spectator
     */
    public static function spectator(string $region, $ttl = 3600)
    {
        return new Spectator($region, $ttl);
    }

    /**
     * Access Summoner V4 endpoints
     *
     * @param $region
     * @param int $ttl
     * @return Summoner
     */
    public static function summoner(string $region, $ttl = 3600)
    {
        return new Summoner($region, $ttl);
    }

    /**
     * Access Third Party Code V4 endpoint
     *
     * @param $region
     * @param int $ttl
     * @return Code
     */
    public static function code(string $region, $ttl = 3600)
    {
        return new Code($region, $ttl);
    }

    /**
     * @return bool
     * @todo
     * @throws LeagueException
     */
    public static function stub()
    {
        throw new LeagueException("Unsupported Endpoint.");
    }

    /**
     * @return bool
     * @todo
     * @throws LeagueException
     */
    public static function tournament()
    {
        throw new LeagueException("Unsupported Endpoint.");
    }

}
