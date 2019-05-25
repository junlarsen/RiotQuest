<?php

namespace RiotQuest\Contracts;

interface DataProviderInterface {

    public static function getProfileIcon(int $id);

    public static function getChampionSquare(string $id);

    public static function getChampionId($id);

    public static function getChampionName($id);

    public static function getChampionKey($id);

}
