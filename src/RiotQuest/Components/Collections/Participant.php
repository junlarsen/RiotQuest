<?php

namespace RiotQuest\Components\Collections;

use Psr\Cache\InvalidArgumentException;
use RiotQuest\Components\DataProviders\Provider;
use RiotQuest\Components\Client\Client;
use RiotQuest\Contracts\LeagueException;

/**
 * Class Participant
 *
 * @see https://developer.riotgames.com/api-methods/#spectator-v4/GET_getFeaturedGames
 *
 * @property double $profileIconId Summoner icon for participant
 * @property double $championId Champion participant played
 * @property string $summonerName Summoner name of participant
 * @property boolean $bot Is this participant a bot?
 * @property double $spell1Id Left summoner spell ID
 * @property double $spell2Id Right summoner spell ID
 * @property double $teamId Team played played on
 *
 * @todo spell icons
 *
 * @package RiotQuest\Components\Framework\Collections
 */
class Participant extends Collection
{

    /**
     * Get the summoner object of this participant
     *
     * @param int $ttl
     * @return Summoner
     * @throws InvalidArgumentException
     * @throws LeagueException
     */
    public function getSummoner($ttl = 3600)
    {
        return Client::summoner($this->region, $ttl)->name($this->summonerName);
    }

    /**
     * Get the champion icon for this player
     *
     * @return string
     */
    public function getProfileIcon()
    {
        return Provider::getProfileIcon($this->profileIconId);
    }

    /**
     * Get the champion icon for this participant
     *
     * @return string
     */
    public function getChampionIcon()
    {
        return Provider::getChampionSquare($this->championId);
    }

    /**
     * Get the champion name for this participant
     *
     * @return string
     */
    public function getChampionName()
    {
        return Provider::getChampionName($this->championId);
    }

}
