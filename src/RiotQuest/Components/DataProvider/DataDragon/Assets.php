<?php

namespace RiotQuest\Components\DataProvider\DataDragon;

use RiotQuest\Components\Framework\Collections\Collection;
use RiotQuest\Components\Framework\Utils\Versions;

class Assets
{

    /**
     * Game version
     *
     * @var
     */
    public static $version;

    /**
     * Loaded files into memory
     *
     * @var array
     */
    public static $loaded = [

    ];

    /**
     * Locale to pull data from
     *
     * @var string
     */
    public static $locale = 'en_US';

    /**
     * DataDragon basepath
     *
     * @var string
     */
    public static $basePath = 'https://ddragon.leagueoflegends.com/cdn/%s';

    /**
     * Basepath for output directory
     *
     * @var string
     */
    public const OUTPUT_DIRECTORY = __DIR__ . '/../../../../storage/static/';

    /**
     * Map over static data endpoints
     *
     * @var array
     */
    public static $map = [
        'champion' => '/data/%s/champion.json',
        'item' => '/data/%s/item.json',
        'champion.full' => '/data/%s/championFull.json',
        'runes' => '/data/%s/runesReforged.json',
        'summoner' => '/data/%s/summoner.json',
        'icon' => '/data/%s/profileicon.json',
        'map' => '/data/%s/map.json',
        'language' => '/data/%s/language.json',
    ];

    /**
     * Paths out for assets for local storage
     *
     * @var array
     */
    public static $out = [
        'champion' => self::OUTPUT_DIRECTORY . '%s/champion.json',
        'item' => self::OUTPUT_DIRECTORY . '%s/item.json',
        'champion.full' => self::OUTPUT_DIRECTORY . '%s/championFull.json',
        'runes' => self::OUTPUT_DIRECTORY . '%s/runes.json',
        'summoner' => self::OUTPUT_DIRECTORY . '%s/summoner.json',
        'icon' => self::OUTPUT_DIRECTORY . '%s/icon.json',
        'map' => self::OUTPUT_DIRECTORY . '%s/map.json',
        'language' => self::OUTPUT_DIRECTORY . '%s/language.json'
    ];

    /***
     * Bootstrapper
     *
     * @throws \Psr\SimpleCache\InvalidArgumentException
     */
    public static function enable()
    {
        static::$version = Versions::current();
    }

    /**
     * Override the locale
     *
     * @param $locale
     */
    public static function setLocate($locale)
    {
        static::$locale = $locale;
    }

    /**
     * Updates an asset in the registry
     *
     * @param $path
     */
    public static function update($path)
    {
        // Create directory if necessary
        if (!is_dir(self::OUTPUT_DIRECTORY . static::$locale)) {
            mkdir(self::OUTPUT_DIRECTORY . static::$locale, 755);
        }
        // Fetch files and store them
        if (in_array($path, array_keys(static::$map))) {
            $file = sprintf(static::$basePath . static::$map[$path], static::$version, static::$locale);
            $output = sprintf(static::$out[$path], static::$locale);
            file_put_contents($output, file_get_contents($file));
        }
    }

    /**
     * Get a file from the registry
     *
     * @param $path
     * @return mixed
     */
    public static function get($path)
    {
        if (in_array($path, array_keys(static::$map))) {
            if (!isset(static::$loaded[$path . '/' . static::$locale])) {
                static::$loaded[$path . '/' . static::$locale] = json_decode(file_get_contents(sprintf(static::$out[$path], static::$locale)), 1);
            }
            return static::$loaded[$path . '/' . static::$locale];
        }
    }

}
