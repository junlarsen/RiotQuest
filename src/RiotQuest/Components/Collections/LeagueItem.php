<?php

namespace RiotQuest\Components\Collections;

use Psr\Cache\InvalidArgumentException;
use RiotQuest\Components\Client\Client;
use RiotQuest\Contracts\LeagueException;

/**
 * Class LeagueItem
 *
 * @see https://developer.riotgames.com/api-methods/#league-v4/GET_getLeagueById
 *
 * @property string $summonerName Summoner name of player
 * @property boolean $hotStreak Is player on hot-streak? 3+ games won in a row
 * @property MiniSeries $miniSeries Promotion series, if player is in promotion series.
 * @property int $wins Number of wins in this season
 * @property boolean $veteran Has player played over 100 games in this league?
 * @property int $losses Number of losses this season
 * @property boolean $freshBlood Did player recently join this league?
 * @property boolean $inactive Is this player decaying?
 * @property string $rank Rank of player, IV III II I
 * @property string $summonerId Summoner ID of player
 * @property int $leaguePoints LP for player
 *
 * @package RiotQuest\Components\Framework\Collections
 */
class LeagueItem extends Collection
{

    /**
     * Get the summoner object for this league item
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
     * Get the winrate for this player
     *
     * @return float|int
     */
    public function getWinrate()
    {
        return $this->wins / ($this->wins + $this->losses) * 100;
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
     * Determine whether this player is in a promotional series
     *
     * @return bool
     */
    public function isInMiniSeries()
    {
        return count($this->miniSeries) > 0;
    }

}
