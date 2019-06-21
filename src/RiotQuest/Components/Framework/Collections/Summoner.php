<?php

namespace RiotQuest\Components\Framework\Collections;

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
     * @return LeagueEntryList
     * @throws LeagueException
     */
    public function getRanked()
    {
        return Client::league($this->region)->positions($this->id);
    }

    /**
     * Get the matchlist for summoner
     *
     * @param array $filters
     * @return MatchHistory
     * @throws LeagueException
     */
    public function getMatchlist($filters = [])
    {
        return Client::match($this->region)->list($this->accountId, $filters);
    }

    /**
     * Get the total mastery score for summoner
     *
     * @return int
     * @throws LeagueException
     */
    public function getMasteryScore()
    {
        return Client::mastery($this->region)->score($this->id);
    }

    /**
     * Get all masteries for summoner
     *
     * @return ChampionMasteryList
     * @throws LeagueException
     */
    public function getMasteryList()
    {
        return Client::mastery($this->region)->all($this->id);
    }

    /**
     * Get the live game for summoner
     *
     * @return CurrentGameInfo
     * @throws LeagueException
     */
    public function getCurrentGame()
    {
        return Client::spectator($this->region)->active($this->id);
    }

    /**
     * Get the set third-party-code for summoner
     *
     * @return string
     * @throws LeagueException
     */
    public function getThirdPartyCode()
    {
        return Client::code($this->region)->id($this->id);
    }

    /**
     * Returns whether this user is unranked or not
     *
     * @return bool
     * @throws LeagueException
     */
    public function isUnranked()
    {
        return count($this->getRanked()->getRankedQueues()) === 0;
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
