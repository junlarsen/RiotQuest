<?php

namespace RiotQuest\Components\Framework\Collections;

/**
 * Class ChampionMasteryList
 *
 * @see https://developer.riotgames.com/api-methods/#champion-mastery-v4/GET_getAllChampionMasteries
 *
 * @list ChampionMastery
 *
 * @package RiotQuest\Components\Framework\Collections
 */
class ChampionMasteryList extends Collection
{

    /**
     * Get the mastery object where the champion ID is equal to given ID
     *
     * @param $id
     * @return ChampionMastery
     */
    public function findChampion($id)
    {
        return array_values($this->filter(function (ChampionMastery $e) use ($id) {
            return $e->championId == $id;
        }))[0];
    }

    /**
     * Get every mastery record where level is equal to given level
     *
     * @param $level
     * @return Collection
     */
    public function getWhereLevelEquals($level)
    {
        return new Collection(array_values($this->filter(function (ChampionMastery $e) use ($level) {
            return $e->championLevel == $level;
        })));
    }

    /**
     * Get every mastery record where level is more than given level
     *
     * @param $level
     * @return Collection
     */
    public function getWhereLevelMoreThan($level)
    {
        return new Collection(array_values($this->filter(function (ChampionMastery $e) use ($level) {
            return $e->championLevel > $level;
        })));
    }

    /**
     * Get every mastery record where level is less than given level
     *
     * @param $level
     * @return Collection
     */
    public function getWhereLevelLessThan($level)
    {
        return new Collection(array_values($this->filter(function (ChampionMastery $e) use ($level) {
            return $e->championLevel < $level;
        })));
    }

    /**
     * Get every mastery record where points is more than given points
     *
     * @param $points
     * @return Collection
     */
    public function getWherePointsMoreThan($points)
    {
        return new Collection(array_values($this->filter(function (ChampionMastery $e) use ($points) {
            return $e->championPoints > $points;
        })));
    }

    /**
     * Get every mastery record where points is less than given points
     *
     * @param $points
     * @return Collection
     */
    public function getWherePointsLessThan($points)
    {
        return new Collection(array_values($this->filter(function (ChampionMastery $e) use ($points) {
            return $e->championPoints < $points;
        })));
    }

    /**
     * Get every mastery record where the chest has been acquired
     *
     * @return Collection
     */
    public function getWhereChestGranted()
    {
        return new Collection(array_values($this->filter(function (ChampionMastery $e) {
            return (bool) $e->chestGranted;
        })));
    }

}
