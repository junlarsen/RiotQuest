<?php

namespace RiotQuest\Components\DataProviders;

use RiotQuest\Components\Framework\Engine\Library;
use RiotQuest\Contracts\DataProviderInterface;

class DataDragon extends BaseProvider implements DataProviderInterface {

    /**
     * Get profile icon
     *
     * @param int $id
     * @return string|null
     */
    public static function getProfileIcon(int $id)
    {
        return Library::replace("https://ddragon.leagueoflegends.com/cdn/{v}/img/profileicon/{id}.png", ['v' => static::$version, 'id' => $id]);
    }

    /**
     * Get square icon for id
     * 
     * @param string $id
     * @return string|null
     */
    public static function getChampionSquare(string $id)
    {
        return Library::replace("https://ddragon.leagueoflegends.com/cdn/{v}/img/champion/{id}.png", ['v' => static::$version, 'id' => $id]);
    }

    /**
     * Get champion name in current locale using any identifier
     *
     * @param $id
     * @return string
     */
    public static function getChampionName($id) {
        return array_values(array_filter(static::get('champion')['data'], function ($el) use ($id) {
            return $el['key'] == $id || $el['id'] == $id || $el['name'] == $id;
        }))[0]['name'] ?? '';
    }

    /**
     * Get champion id using any identifier
     *
     * @param $id
     * @return string
     */
    public static function getChampionId($id) {
        return array_values(array_filter(static::get('champion')['data'], function ($el) use ($id) {
                return $el['key'] == $id || $el['id'] == $id || $el['name'] == $id;
            }))[0]['id'] ?? '';
    }

    /**
     * Get champion key in current locale using any identifier
     *
     * @param $id
     * @return string
     */
    public static function getChampionKey($id) {
        return array_values(array_filter(static::get('champion')['data'], function ($el) use ($id) {
                return $el['key'] == $id || $el['id'] == $id || $el['name'] == $id;
            }))[0]['key'] ?? '';
    }

}
