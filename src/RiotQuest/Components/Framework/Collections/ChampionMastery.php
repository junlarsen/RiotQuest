<?php

namespace RiotQuest\Components\Framework\Collections;

use Carbon\Carbon;
use Carbon\CarbonInterface;
use RiotQuest\Components\DataProviders\Provider;
use RiotQuest\Components\Framework\Client\Client;
use RiotQuest\Contracts\LeagueException;

/**
 * Class ChampionMastery
 *
 * @see https://developer.riotgames.com/api-methods/#champion-mastery-v4/GET_getChampionMastery
 *
 * @property boolean $chestGranted Has a chest been earned this season for this champion?
 * @property int $championLevel Mastery level on champion: 1-7
 * @property int $championPoints Number of points on champion
 * @property double $championId The champion ID
 * @property double $championPointsUntilNextLevel Points until next mastery level
 * @property double $lastPlayTime Unix Timestamp of last playtime
 * @property int $tokensEarned Mastery tokens earned towards graduation
 * @property double $championPointsSinceLastLevel Points earned since last level
 * @property string $summonerId The summoner ID
 *
 * @package RiotQuest\Components\Framework\Collections
 */
class ChampionMastery extends Collection
{

    /**
     * Gets the summoner which holds this mastery
     *
     * @return Summoner
     * @throws LeagueException
     */
    public function getSummoner()
    {
        return Client::summoner($this->region)->id($this->summonerId);
    }

    /**
     * Get champion icon for banned champion
     *
     * @return string
     */
    public function getChampionIcon()
    {
        return Provider::getProfileIcon(Provider::getChampionName($this->championId));
    }

    /**
     * Get Carbon instance for last playtime
     *
     * @return Carbon|CarbonInterface
     */
    public function getLastPlayed()
    {
        return Carbon::createFromTimestamp($this->lastPlayTime);
    }

    /**
     * Checks whether chest has been granted
     *
     * @return bool
     */
    public function isChestGranted()
    {
        return (bool)$this->chestGranted;
    }

    /**
     * Gets the champion name for this mastery record
     *
     * @return string
     */
    public function getChampionName()
    {
        return Provider::getChampionName($this->championId);
    }

}
