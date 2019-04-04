<?php

namespace RiotQuest\Components\Framework\Collections;

use RiotQuest\Client;
use RiotQuest\Components\DataProvider\DataDragon\Dragon;

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
     * @throws \Psr\SimpleCache\InvalidArgumentException
     */
    public function getSummonerIcon()
    {
        return Dragon::getProfileIcon($this->profileIconId);
    }

    /**
     * Get the ranked positions for summoner
     *
     * @return LeaguePositionList
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Psr\SimpleCache\InvalidArgumentException
     * @throws \ReflectionException
     * @throws \RiotQuest\Contracts\RiotQuestException
     */
    public function getRanked()
    {
        return Client::league($this->region)->positions($this->id);
    }

    /**
     * Get the matchlist for summoner
     *
     * @return MatchHistory
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Psr\SimpleCache\InvalidArgumentException
     * @throws \ReflectionException
     * @throws \RiotQuest\Contracts\RiotQuestException
     */
    public function getMatchlist($filters = [])
    {
        return Client::match($this->region)->list($this->accountId, $filters);
    }

    /**
     * Get the total mastery score for summoner
     *
     * @return int
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Psr\SimpleCache\InvalidArgumentException
     * @throws \ReflectionException
     * @throws \RiotQuest\Contracts\RiotQuestException
     */
    public function getMasteryScore()
    {
        return Client::mastery($this->region)->score($this->id);
    }

    /**
     * Get all masteries for summoner
     *
     * @return ChampionMasteryList
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Psr\SimpleCache\InvalidArgumentException
     * @throws \ReflectionException
     * @throws \RiotQuest\Contracts\RiotQuestException
     */
    public function getMasteryList()
    {
        return Client::mastery($this->region)->all($this->id);
    }

    /**
     * Get the live game for summoner
     *
     * @return CurrentGameInfo
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Psr\SimpleCache\InvalidArgumentException
     * @throws \ReflectionException
     * @throws \RiotQuest\Contracts\RiotQuestException
     */
    public function getCurrentGame()
    {
        return Client::spectator($this->region)->active($this->id);
    }

    /**
     * Get the set third-party-code for summoner
     *
     * @return string
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Psr\SimpleCache\InvalidArgumentException
     * @throws \ReflectionException
     * @throws \RiotQuest\Contracts\RiotQuestException
     */
    public function getExternalCode()
    {
        return Client::code($this->region)->id($this->id);
    }

    /**
     * Returns whether this user is unranked or not
     *
     * @return bool
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Psr\SimpleCache\InvalidArgumentException
     * @throws \ReflectionException
     * @throws \RiotQuest\Contracts\RiotQuestException
     */
    public function isUnranked()
    {
        return count($this->getRanked()->getRankedQueues()) === 0;
    }

}
