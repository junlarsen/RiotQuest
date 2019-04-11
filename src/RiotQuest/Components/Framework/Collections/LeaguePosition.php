<?php

namespace RiotQuest\Components\Framework\Collections;

use RiotQuest\Components\Framework\Client\Client;

/**
 * Class LeaguePosition
 *
 * @see https://developer.riotgames.com/api-methods/#league-v4/GET_getAllLeaguePositionsForSummoner
 *
 * @property string $queueType The queue type RANKED_SOLO_5x5, RANKED_FLEX_SR, RANKED_FLEX_TT
 * @property string $summonerName Summoner name for this league item
 * @property string $position The current position for this player
 * @property boolean $hotStreak Hotstreak (3+ wins in a row)
 * @property MiniSeries $miniSeries Promotion series, if in promotion series
 * @property int $wins Number of wins this season
 * @property boolean $veteran Has player played 100+ games in this league?
 * @property int $losses Number of losses this season
 * @property string $rank Rank in tier ( IV, III, II, I )
 * @property string $leagueId League ID for this summoner
 * @property boolean $inactive Is this user decaying?
 * @property boolean $freshBlood Did this user recently join this league?
 * @property string $leagueName Name of league
 * @property string $tier Tier of rank ( BRONZE, SILVER, etc )
 * @property string $summonerId SummonerID of user
 * @property int $leaguePoints Amount of LP
 *
 * @package RiotQuest\Components\Framework\Collections
 */
class LeaguePosition extends Collection
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
     * @return Summoner
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Psr\SimpleCache\InvalidArgumentException
     * @throws \ReflectionException
     * @throws \RiotQuest\Contracts\LeagueException
     */
    public function getSummoner()
    {
        return Client::summoner( $this->region)->id($this->summonerId);
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
