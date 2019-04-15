<?php

namespace RiotQuest\Components\Framework\Collections;

use RiotQuest\Components\DataProvider\DataDragon\Dragon;
use RiotQuest\Components\Framework\Utils\Champion;
use RiotQuest\Constants;

/**
 * Class TeamBans
 *
 * @see https://developer.riotgames.com/api-methods/#match-v4/GET_getMatch
 *
 * @property int $pickTurn Which turn this ban was made
 * @property int $championId ID of champion who was banned
 *
 * @package RiotQuest\Components\Framework\Collections
 */
class TeamBans extends Collection
{

    /**
     * Get champion icon for banned champion
     *
     * @return string
     */
    public function getChampionIcon()
    {
        return Dragon::getChampionSquare(Constants::champion()->getChampionName($this->championId));
    }

}
