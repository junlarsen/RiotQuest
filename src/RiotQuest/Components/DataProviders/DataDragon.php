<?php

namespace RiotQuest\Components\DataProviders;

use League\Flysystem\FileExistsException;
use Psr\SimpleCache\InvalidArgumentException;
use RiotQuest\Components\Framework\Engine\Utils;
use RiotQuest\Contracts\DataProviderInterface;
use RiotQuest\Contracts\LeagueException;

class DataDragon extends BaseProvider implements DataProviderInterface
{

    /**
     * Get profile icon
     *
     * @param int $id
     * @return string|null
     */
    public static function getProfileIcon(int $id): string
    {
        return Utils::replace("https://ddragon.leagueoflegends.com/cdn/{v}/img/profileicon/{id}.png", ['v' => static::$version, 'id' => $id]);
    }

    /**
     * Get square icon for id
     *
     * @param string $id
     * @return string|null
     */
    public static function getChampionSquare(string $id): string
    {
        return Utils::replace("https://ddragon.leagueoflegends.com/cdn/{v}/img/champion/{id}.png", ['v' => static::$version, 'id' => $id]);
    }

    /**
     * Get champion name in current locale using any identifier
     *
     * @param $id
     * @return string
     * @throws FileExistsException
     * @throws InvalidArgumentException
     * @throws LeagueException
     */
    public static function getChampionName($id): string
    {
        return array_values(array_filter(static::get('champion')['data'], function ($el) use ($id) {
                return $el['key'] == $id || $el['id'] == $id || $el['name'] == $id;
            }))[0]['name'] ?? '';
    }

    /**
     * Get champion id using any identifier
     *
     * @param $id
     * @return int
     * @throws FileExistsException
     * @throws InvalidArgumentException
     * @throws LeagueException
     */
    public static function getChampionId($id): int
    {
        return array_values(array_filter(static::get('champion')['data'], function ($el) use ($id) {
                return $el['key'] == $id || $el['id'] == $id || $el['name'] == $id;
            }))[0]['id'] ?? '';
    }

    /**
     * Get champion key in current locale using any identifier
     *
     * @param $id
     * @return string
     * @throws FileExistsException
     * @throws InvalidArgumentException
     * @throws LeagueException
     */
    public static function getChampionKey($id): string
    {
        return array_values(array_filter(static::get('champion')['data'], function ($el) use ($id) {
                return $el['key'] == $id || $el['id'] == $id || $el['name'] == $id;
            }))[0]['key'] ?? '';
    }

}
