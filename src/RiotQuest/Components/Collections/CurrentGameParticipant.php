<?php

namespace RiotQuest\Components\Collections;

use Psr\Cache\InvalidArgumentException;
use RiotQuest\Components\DataProviders\Provider;
use RiotQuest\Components\Client\Client;
use RiotQuest\Contracts\LeagueException;

/**
 * Class CurrentGameParticipant
 *
 * @see https://developer.riotgames.com/api-methods/#spectator-v4/GET_getCurrentGameInfoBySummoner
 *
 * @property double $profileIconId Summoner Icon ID
 * @property double $championId Champion ID which player is playing
 * @property string $summonerName Summoner name of player
 * @property GameCustomizationObjectList $gameCustomizationObjects Game customization objects
 * @property boolean $bot Is player a bot?
 * @property Perks $perks Current runes summoner is using
 * @property double $spell1Id Spell slot one ID
 * @property double $spell2Id Spell slot two ID
 * @property double $teamId Team ID for player
 * @property string $summonerId Summoner ID of player
 *
 * @todo spell icons
 *
 * @package RiotQuest\Components\Framework\Collections
 */
class CurrentGameParticipant extends Collection
{

    /**
     * Get champion icon
     *
     * @return string
     */
    public function getChampionIcon()
    {
        return Provider::getChampionSquare($this->championId);
    }

    /**
     * Get summoner object
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
     * Get summoner icon link
     *
     * @return string
     */
    public function getSummonerIcon()
    {
        return Provider::getProfileIcon($this->profileIconId);
    }

    /**
     * Get champion name by its id
     *
     * @return string
     */
    public function getChampionName()
    {
        return Provider::getChampionName($this->championId);
    }

}
