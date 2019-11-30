<?php

namespace RiotQuest\Components\Collections;

/**
 * Class CurrentGameParticipantList
 *
 * @see https://developer.riotgames.com/api-methods/#spectator-v4/GET_getCurrentGameInfoBySummoner
 *
 * @list CurrentGameParticipant
 *
 * @package RiotQuest\Components\Framework\Collections
 */
class CurrentGameParticipantList extends Collection
{

    /**
     * Get all the summoner objects in this list
     *
     * @return Collection
     */
    public function getSummoners()
    {
        return new Collection($this->mapArr(fn (CurrentGameParticipant $e) => $e->getSummoner()));
    }

    /**
     * Search for summoner name
     *
     * @param string $name
     * @return string
     */
    public function getWhereName(string $name)
    {
        return array_values($this->filterArr(fn (CurrentGameParticipant $e) => $e->summonerName === $name))[0];
    }

}
