<?php

namespace RiotQuest\Contracts;

/**
 * Interface DataProviderInterface
 * @package RiotQuest\Contracts
 */
interface DataProviderInterface
{

    /**
     * @param int $id
     * @return string
     */
    public static function getProfileIcon(int $id): string;

    /**
     * @param string $id
     * @return string
     */
    public static function getChampionSquare(string $id): string;

    /**
     * @param $id
     * @return int
     */
    public static function getChampionId($id): int;

    /**
     * @param $id
     * @return string
     */
    public static function getChampionName($id): string;

    /**
     * @param $id
     * @return string
     */
    public static function getChampionKey($id): string;

}
