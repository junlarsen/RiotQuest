<?php

namespace RiotQuest\Components\Framework\Collections;

use Carbon\Carbon;
use RiotQuest\Components\Framework\Client\Client;
use RiotQuest\Contracts\LeagueException;

/**
 * Class Match
 *
 * @see https://developer.riotgames.com/api-methods/#match-v4/GET_getMatch
 *
 * @property int $seasonId Season ID the game was played on
 * @property int $queueId Queue game was played on
 * @property double $gameId Game ID of game
 * @property ParticipantIdentityList $participantIdentities List of participants in this game
 * @property string $gameVersion Game version game was played on
 * @property string $platformId Region game was played on
 * @property string $gameMode Game mode of game
 * @property int $mapId Which map the game was played on
 * @property string $gameType Which type of game this was
 * @property TeamStatsList $teams List of team stats
 * @property MatchParticipantList $participants List of player stats
 * @property double $gameDuration Game duration in ms
 * @property double $gameCreation Game creation in UNIX timestamp
 *
 * @package RiotQuest\Components\Framework\Collections
 */
class Match extends Collection
{

    /**
     * Gets the timeline for this match
     *
     * @return MatchTimeline
     * @throws LeagueException
     */
    public function getTimeline()
    {
        return Client::match($this->region)->timeline($this->gameId);
    }

    /**
     * Get relative time since this game was ended in ms
     *
     * @return int
     */
    public function getRelativeStartTimeMs()
    {
        return Carbon::now()->diffInMilliseconds(Carbon::createFromTimestampMs($this->gameCreation));
    }

}
