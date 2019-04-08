<?php

namespace RiotQuest\Components\Framework\Collections;

/**
 * Class ParticipantIdentityList
 *
 * @see https://developer.riotgames.com/api-methods/#match-v4/GET_getMatch
 *
 * @list ParticipantIdentity
 *
 * @package RiotQuest\Components\Framework\Collections
 */
class ParticipantIdentityList extends Collection
{

    /**
     * Get all the summoner objects in this game
     *
     * @return Collection
     */
    public function getSummoners()
    {
        return new Collection(array_values($this->map(function (ParticipantIdentity $e) {
            return $e->player->getSummoner();
        })));
    }

    /**
     * Get each summoner name
     *
     * @return Collection
     */
    public function getSummonerNames()
    {
        return new Collection(array_values($this->map(function (ParticipantIdentity $e) {
            return $e->player->summonerName;
        })));
    }

}
