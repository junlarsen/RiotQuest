<?php

namespace RiotQuest\Components\DataProviders;

use League\Flysystem\FileExistsException;
use Psr\Cache\InvalidArgumentException;
use RiotQuest\Components\Engine\Utils;
use RiotQuest\Contracts\DataProviderInterface;

/**
 * Class DataDragon
 * @package RiotQuest\Components\DataProviders
 */
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
     */
    public static function getChampionName($id): string
    {
        return array_values(array_filter(static::get('champion')['data'], fn ($el) => in_array($id, [$el['key'], $el['id'], $el['name']])))[0]['name'] ?? '';
    }

    /**
     * Get champion id using any identifier
     *
     * @param $id
     * @return int
     * @throws FileExistsException
     * @throws InvalidArgumentException
     */
    public static function getChampionId($id): int
    {
        return array_values(array_filter(static::get('champion')['data'], fn ($el) => in_array($id, [$el['key'], $el['id'], $el['name']])))[0]['id'] ?? '';
    }

    /**
     * Get champion key in current locale using any identifier
     *
     * @param $id
     * @return string
     * @throws FileExistsException
     * @throws InvalidArgumentException
     */
    public static function getChampionKey($id): string
    {
        return array_values(array_filter(static::get('champion')['data'], fn ($el) => in_array($id, [$el['key'], $el['id'], $el['name']])))[0]['key'] ?? '';
    }

}
