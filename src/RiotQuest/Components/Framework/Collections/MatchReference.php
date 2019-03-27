<?php

namespace RiotQuest\Components\Framework\Collections;

use RiotQuest\Client;

/**
 * Class MatchReference
 *
 * @see https://developer.riotgames.com/api-methods/#match-v4/GET_getMatchlist
 *
 * @property string $lane
 * @property double $gameId
 * @property int $champion
 * @property string $platformId
 * @property int $season
 * @property int $queue
 * @property string $role
 * @property double $timestamp
 *
 * @package RiotQuest\Components\Framework\Collections
 */
class MatchReference extends Collection
{

    /**
     * Get the current match for this reference
     *
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Psr\SimpleCache\InvalidArgumentException
     * @throws \ReflectionException
     * @throws \RiotQuest\Contracts\RiotQuestException
     */
    public function getMatch()
    {
        return Client::match($this->region)->id($this->gameId);
    }

}
