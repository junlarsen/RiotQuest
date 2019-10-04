<?php

namespace RiotQuest\Components\Collections;

use Psr\Cache\InvalidArgumentException;
use RiotQuest\Client;
use RiotQuest\Components\DataProviders\Provider;
use RiotQuest\Contracts\LeagueException;

/**
 * Class Summoner
 *
 * @see https://developer.riotgames.com/api-methods/#summoner-v4/GET_getBySummonerName
 *
 * @property string $id
 * @property string $accountId
 * @property string $puuid
 * @property string $name
 * @property int $profileIconId
 * @property double $revisionDate
 * @property int $summonerLevel
 *
 * @package RiotQuest\Components\Framework\Collections
 */
class Summoner extends Collection
{

    /**
     * Get the current summoner icon link
     *
     * @return string
     */
    public function getSummonerIcon()
    {
        return Provider::getProfileIcon($this->profileIconId);
    }

    /**
     * Get the ranked positions for summoner
     *
     * @param int $ttl
     * @return LeagueEntryList
     * @throws InvalidArgumentException
     * @throws LeagueException
     */
    public function getRanked($ttl = 3600)
    {
        return Client::league($this->region, $ttl)->positions($this->id);
    }

    /**
     * Get the matchlist for summoner
     *
     * @param int $ttl
     * @param array $filters
     * @return MatchHistory
     * @throws InvalidArgumentException
     * @throws LeagueException
     */
    public function getMatchlist($ttl = 3600, $filters = [])
    {
        return Client::match($this->region, $ttl)->list($this->accountId, $filters);
    }

    /**
     * Get the total mastery score for summoner
     *
     * @param int $ttl
     * @return int
     * @throws InvalidArgumentException
     * @throws LeagueException
     */
    public function getMasteryScore($ttl = 3600)
    {
        return Client::mastery($this->region, $ttl)->score($this->id);
    }

    /**
     * Get all masteries for summoner
     *
     * @param int $ttl
     * @return ChampionMasteryList
     * @throws InvalidArgumentException
     * @throws LeagueException
     */
    public function getMasteryList($ttl = 3600)
    {
        return Client::mastery($this->region, $ttl)->all($this->id);
    }

    /**
     * Get the live game for summoner
     *
     * @param int $ttl
     * @return CurrentGameInfo
     * @throws InvalidArgumentException
     * @throws LeagueException
     */
    public function getCurrentGame($ttl = 3600)
    {
        return Client::spectator($this->region, $ttl)->active($this->id);
    }

    /**
     * Get the set third-party-code for summoner
     *
     * Note: does not need TTL as Code always has 0 ttl
     *
     * @return string
     * @throws LeagueException
     * @throws InvalidArgumentException
     */
    public function getThirdPartyCode()
    {
        return Client::code($this->region)->id($this->id);
    }

    /**
     * Returns whether this user is unranked or not
     *
     * @param int $ttl
     * @return bool
     * @throws InvalidArgumentException
     * @throws LeagueException
     */
    public function isUnranked($ttl = 3600)
    {
        return count($this->getRanked($ttl)->getRankedQueues()) === 0;
    }

    /**
     * Determines whether the player gets to use the low-level or normal rotation
     *
     * @return bool
     */
    public function isAboveNewPlayerThreshold()
    {
        return $this->summonerLevel > 10;
    }

}
