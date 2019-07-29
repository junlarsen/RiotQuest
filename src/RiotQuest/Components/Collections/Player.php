<?php

namespace RiotQuest\Components\Collections;

use Psr\Cache\InvalidArgumentException;
use RiotQuest\Components\DataProviders\Provider;
use RiotQuest\Components\Client\Client;
use RiotQuest\Contracts\LeagueException;

/**
 * Class Player
 *
 * @see https://developer.riotgames.com/api-methods/#match-v4/GET_getMatch
 *
 * @property string $currentPlatformId The current region the summoner is on
 * @property string $summonerName Summoner name of player
 * @property string $matchHistoryUri Link to match history
 * @property string $platformId The region the account was created on
 * @property string $currentAccountId Current account ID
 * @property int $profileIcon Summoner icon ID
 * @property string $summonerId Current summoner Id
 * @property string $accountId Original account ID
 *
 * @package RiotQuest\Components\Framework\Collections
 */
class Player extends Collection
{

    /**
     * Get the summoner icon link
     *
     * @return string
     */
    public function getSummonerIcon()
    {
        return Provider::getProfileIcon($this->profileIcon);
    }

    /**
     * Get the summoner object
     *
     * @return Summoner
     * @throws LeagueException
     * @throws InvalidArgumentException
     */
    public function getSummoner()
    {
        return Client::summoner($this->region)->id($this->summonerId);
    }

}
