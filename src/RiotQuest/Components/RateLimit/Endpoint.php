<?php

namespace RiotQuest\Components\RateLimit;

use RiotQuest\Components\Riot\Client\Client;
use RiotQuest\Contracts\RateLimit;

class Endpoint implements RateLimit
{

    protected static $cache;

    public static function enable()
    {
        static::$cache = Client::getCache();
    }

    public static function available($region, $endpoint = null)
    {
        if (static::$cache->has('riotquest.limits.ends')) {
            $items = json_decode(static::$cache->get('riotquest.limits.ends'), 1);
            if (isset($items[$region][$endpoint]) && $items[$region][$endpoint]['count'] + 1 > $items[$region][$endpoint]['cap']) {
                return false;
            }
        }
        return true;
    }

    public static function hit($region, $endpoint = null, $scope = 'STANDARD', $lim = ['interval' => 60, 'count' => 20])
    {
        $time = time();
        if (!static::$cache->has('riotquest.limits.ends')) {
            static::$cache->set('riotquest.limits.ends', json_encode([
                $region => [
                    $endpoint => [
                        'cap' => $lim['count'],
                        'count' => 1,
                        'ttl' => $time + $lim['interval']
                    ]
                ]
            ]), (int) $lim['interval']);
        } else {
            $current = json_decode(static::$cache->get('riotquest.limits.ends'), 1);
            if (isset($current[$region][$endpoint])) {
                $current[$region][$endpoint] = [
                    'cap' => $lim['count'],
                    'count' => $current[$region][$endpoint]['count'] + 1,
                    'ttl' => $current[$region][$endpoint]['ttl']
                ];
                static::$cache->set('riotquest.limits.ends', json_encode($current), (int) $current[$region][$endpoint]['ttl'] - $time);
            }
        }
    }

}
