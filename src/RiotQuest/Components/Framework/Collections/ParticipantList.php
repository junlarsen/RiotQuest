<?php

namespace RiotQuest\Components\Framework\Collections;

/**
 * Class ParticipantList
 *
 * @see https://developer.riotgames.com/api-methods/#spectator-v4/GET_getFeaturedGames
 *
 * @list Participant
 *
 * @package RiotQuest\Components\Framework\Collections
 */
class ParticipantList extends Collection
{

    /**
     * Get all the summoner objects in this list
     *
     * @return Collection
     */
    public function getSummoners()
    {
        return new Collection($this->map(function (Participant $e) {
            return $e->getSummoner();
        }));
    }

    /**
     * Search for summoner name
     *
     * @param $name
     * @return string
     */
    public function getWhereName(string $name)
    {
        return array_values($this->filterArr(function (Participant $e) use ($name) {
            return $e->summonerName == $name;
        }))[0];
    }

}
