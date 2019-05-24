<?php

namespace RiotQuest\Contracts;

interface DataProviderInterface {

    public static function boot(): void;

    public static function getProfileIcon(int $id): string;

    public static function getChampionSquare(int $id): string;

}
