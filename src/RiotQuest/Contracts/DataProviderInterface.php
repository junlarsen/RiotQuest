<?php

namespace RiotQuest\Contracts;

interface DataProviderInterface
{

    public static function getProfileIcon(int $id): string;

    public static function getChampionSquare(string $id): string;

    public static function getChampionId($id): int;

    public static function getChampionName($id): string;

    public static function getChampionKey($id): string;

}
