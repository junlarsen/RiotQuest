<?php

namespace RiotQuest\Components\DataProviders;

use RiotQuest\Components\Framework\Client\Application;

/**
 * Class Provider
 *
 * @method static string getProfileIcon(int $id)
 * @method static string getChampionSquare(int $id)
 * @method static int    getChampionId($id)
 * @method static string getChampionName($id)
 * @method static string getChampionKey($id)
 *
 * @package RiotQuest\Components\DataProviders
 */
class Provider extends BaseProvider
{

    /**
     * @var
     */
    private static $provider;

    /**
     * @param $name
     * @param $arguments
     * @return mixed
     */
    public static function __callStatic($name, $arguments)
    {
        return call_user_func_array([Application::getInstance()->getProvider(), $name], $arguments);
    }

    /**
     * Boot loader for data provider
     */
    public static function boot(): void
    {
        static::$provider = Application::getInstance()->getProvider();
    }


}
