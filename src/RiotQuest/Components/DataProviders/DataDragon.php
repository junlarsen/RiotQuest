<?php

namespace RiotQuest\Components\DataProviders;

use RiotQuest\Components\Framework\Engine\Library;
use RiotQuest\Contracts\DataProviderInterface;

class DataDragon extends BaseProvider implements DataProviderInterface {

    public static function boot(): void
    {
        // TODO: Implement boot() method.
    }

    public static function getProfileIcon(int $id): string
    {
        return Library::replace("https://ddragon.leagueoflegends.com/cdn/{v}/img/profileicon/{id}.png", ['v' => static::$version, 'id' => $id]);
    }

    public static function getChampionSquare(int $id): string
    {
        return Library::replace("https://ddragon.leagueoflegends.com/cdn/{v}/img/champion/{id}.png", ['v' => static::$version, 'id' => $id]);
    }

}
