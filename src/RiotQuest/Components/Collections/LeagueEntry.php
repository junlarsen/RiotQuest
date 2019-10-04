<?php

namespace RiotQuest\Components\Collections;

use Psr\Cache\InvalidArgumentException;
use RiotQuest\Client;
use RiotQuest\Contracts\LeagueException;

/**
 * Class LeagueEntry
 *
 * @see https://developer.riotgames.com/api-methods/#league-v4/GET_getLeagueEntriesForSummoner
 *
 * @property string $queueType
 * @property string $summonerName
 * @property boolean $hotStreak
 * @property MiniSeries $miniSeries
 * @property int $wins
 * @property boolean $veteran
 * @property int $losses
 * @property string $rank
 * @property string $leagueId
 * @property boolean $inactive
 * @property boolean $freshBlood
 * @property string $tier
 * @property string $summonerId
 * @property int $leaguePoints
 *
 * @package RiotQuest\Tests\Collections
 */
class LeagueEntry extends Collection
{

    /**
     * Get the winrate for this player
     *
     * @return float|int
     */
    public function getWinrate()
    {
        return $this->wins / ($this->wins + $this->losses) * 100;
    }

    /**
     * Get the league string (eg. BRONZE I 76 LP)
     *
     * @return string
     */
    public function getFormattedName()
    {
        return sprintf("%s %s %d LP", $this->tier, $this->rank, $this->leaguePoints);
    }

    /**
     * Get amount of games played
     *
     * @return int
     */
    public function getGamesPlayed()
    {
        return ($this->wins ?: 0) + ($this->losses ?: 0);
    }

    /**
     * Get the summoner object of this player
     *
     * @param int $ttl
     * @return Summoner
     * @throws InvalidArgumentException
     * @throws LeagueException
     */
    public function getSummoner($ttl = 3600)
    {
        return Client::summoner($this->region, $ttl)->id($this->summonerId);
    }

    /**
     * Determine whether this player is in a promotional series
     *
     * @return bool
     */
    public function isInMiniSeries()
    {
        return count($this->miniSeries) > 0;
    }

}
