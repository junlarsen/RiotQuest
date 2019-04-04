<?php

namespace RiotQuest\Components\Framework\Collections;

use Carbon\Carbon;
use RiotQuest\Client;

/**
 * Class MatchReference
 *
 * @see https://developer.riotgames.com/api-methods/#match-v4/GET_getMatchlist
 *
 * @property string $lane Which lane player player ( TOP, JUNGLE, MID, BOT, NONE )
 * @property double $gameId Game ID for game
 * @property int $champion Champion which player played
 * @property string $platformId Region game was played on
 * @property int $season Season game was played in
 * @property int $queue Queue game was played on
 * @property string $role Role player player ( SOLO, DUO, DUO_SUPPORT, DUO_CARRY, NONE )
 * @property double $timestamp UNIX timestamp for game end
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

    /**
     * Get relative time since this game was ended in ms
     *
     * @return int
     */
    public function getRelativeStartTimeMs()
    {
        return Carbon::now()->diffInMilliseconds((int) $this->timestamp);
    }

}
