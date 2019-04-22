<?php

namespace RiotQuest\Components\Framework\Utils;

use RiotQuest\Components\DataProvider\DataDragon\Assets;

class Champion
{

    /**
     * Get a champion name by any identifier
     *
     * @param $id
     * @return string
     */
    public static function getChampionName($id)
    {
        return array_values(array_filter(Assets::get('champion')['data'], function ($e) use ($id) {
            return $e['key'] == $id || $e['id'] == $id || $e['name'] == $id;
        }))[0]['name'] ?? '';
    }

    /**
     * Get a champion id by any identifier
     *
     * @param $id
     * @return string
     */
    public static function getChampionId($id)
    {
        return array_values(array_filter(Assets::get('champion')['data'], function ($e) use ($id) {
                return $e['key'] == $id || $e['id'] == $id || $e['name'] == $id;
            }))[0]['id'] ?? '';
    }

    /**
     * Get a champion key by any identifier
     *
     * @param $id
     * @return string
     */
    public static function getChampionKey($id)
    {
        return (int) array_values(array_filter(Assets::get('champion')['data'], function ($e) use ($id) {
                return $e['key'] == $id || $e['id'] == $id || $e['name'] == $id;
            }))[0]['key'] ?? 0;
    }

}
