<?php

namespace RiotQuest\Components\DataProviders;

use RiotQuest\Components\Game\Game;

class BaseProvider {

    /**
     * The version to pull data from
     *
     * @var string
     */
    protected static $version;

    /**
     * @internal Boot to set version
     * 
     * @throws \Psr\SimpleCache\InvalidArgumentException
     * @throws \RiotQuest\Contracts\LeagueException
     */
    public static function onEnable() {
        static::$version = Game::current();
    }

    /**
     * Override the version with a custom one.
     *
     * @param string $version
     */
    public static function override(string $version) {
        static::$version = $version;
    }

}
