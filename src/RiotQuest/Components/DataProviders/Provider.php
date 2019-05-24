<?php

namespace RiotQuest\Components\DataProviders;

use RiotQuest\Components\Framework\Client\Client;
use RiotQuest\Contracts\DataProviderInterface;

class Provider extends BaseProvider implements DataProviderInterface {

    private static $provider;

    public static function boot(): void
    {
        static::$provider = Client::getProvider();
    }

    public static function getProfileIcon(int $id): string
    {
        return call_user_func_array([static::$provider, 'getProfileIcon'], [$id]);
    }

    public static function getChampionSquare(int $id): string
    {
        return call_user_func_array([static::$provider, 'getChampionSquare'], [$id]);
    }


}