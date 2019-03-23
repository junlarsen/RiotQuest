<?php

namespace RiotQuest\Components\RateLimit;

use RiotQuest\Components\Riot\Client\Client;
use RiotQuest\Contracts\RateLimit;

class Application implements RateLimit
{

    protected static $limits = [];

    protected static $cache;

    public static function enable()
    {
        static::$limits['STANDARD'] = Client::getLimits('STANDARD') ?? [];
        static::$limits['TOURNAMENT'] = Client::getLimits('TOURNAMENT') ?? [];
        static::$cache = Client::getCache();
    }

    public static function available($region, $endpoint = null)
    {
        if (static::$cache->has('riotquest.limits.app')) {
            $items = json_decode(static::$cache->get('riotquest.limits.app'), 1);
            if (isset($items[$region]) && $items[$region]['count'] + 1 > $items[$region]['cap']) {
                return false;
            }
        }
        return true;
    }

    public static function hit($region, $endpoint = null, $scope = 'STANDARD')
    {
        $time = time();
        if (!static::$cache->has('riotquest.limits.app')) {
            static::$cache->set('riotquest.limits.app', json_encode([
                $region => [
                    'cap' => (int)static::$limits[$scope]['count'],
                    'count' => 1,
                    'ttl' => $time + (int)static::$limits[$scope]['interval']
                ]
            ]), (int)static::$limits[$scope]['interval']);
        } else {
            $current = json_decode(static::$cache->get('riotquest.limits.app'), 1);
            if (isset($current[$region]['ttl'])) {
                $current[$region] = [
                    'cap' => (int)static::$limits[$scope]['count'],
                    'count' => $current[$region]['count'] + 1,
                    'ttl' => $current[$region]['ttl']
                ];
                static::$cache->set('riotquest.limits.app', json_encode($current), ($current[$region]['ttl'] - $time));
            }
        }
    }

}
