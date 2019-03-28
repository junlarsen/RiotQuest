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
    public function getWhere($id)
    {
        return array_values($this->filter(function (ChampionMastery $e) use ($id) {
            return $e->championId == $id;
        }))[0];
    }

}
