<?php

namespace RiotQuest\Components\DataProvider\DataDragon;

use RiotQuest\Components\Framework\Utils\Versions;

class Dragon
{

    /**
     * Game version to use
     *
     * @var string
     */
    private static $version;

    /**
     * Dragon constructor.
     *
     * @throws \Psr\SimpleCache\InvalidArgumentException
     */
    public static function enable()
    {
        static::$version = Versions::current();
    }

    /**
     * Override the current version
     *
     * @param $version
     */
    public static function overrideVersion($version)
    {
        static::$version = $version;
    }

    /**
     * Resets the overwritten version
     *
     * @throws \Psr\SimpleCache\InvalidArgumentException
     */
    public static function resetVersion()
    {
        static::$version = Versions::current();
    }

    /**
     * Get a summoner icon link
     *
     * @param $id
     * @return string
     */
    public static function getProfileIcon($id)
    {
        return sprintf('https://ddragon.leagueoflegends.com/cdn/%s/img/profileicon/%d.png', static::$version, $id);
    }

    /**
     * Get a champion square icon
     *
     * @param $id
     * @return string
     */
    public static function getChampionSquare($id)
    {
        return sprintf('https://ddragon.leagueoflegends.com/cdn/%s/img/champion/%s.png', static::$version, $id);
    }

}
