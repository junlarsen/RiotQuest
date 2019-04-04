<?php

namespace RiotQuest\Components\Framework\Collections;

use RiotQuest\Components\DataProvider\DataDragon\Dragon;
use RiotQuest\Components\Framework\Utils\Champion;
use RiotQuest\Components\Framework\Utils\Game;

/**
 * Class BannedChampion
 *
 * @see https://developer.riotgames.com/api-methods/#spectator-v4/GET_getFeaturedGames
 *
 * @property int $pickTurn The pick turn this ban was made
 * @property double $championId The champion ID for the ban
 * @property double $teamId ID for the team who banned this champion
 *
 * @package RiotQuest\Components\Framework\Collections
 */
class BannedChampion extends Collection
{

    /**
     * Get champion icon for banned champion
     *
     * @return string
     */
    public function getChampionIcon()
    {
        return Dragon::getChampionSquare(Champion::getChampionId($this->championId));
    }

    /**
     * Get team name ( BLUE or RED )
     *
     * @return string
     */
    public function getTeamName()
    {
        return Game::translateTeam($this->teamId);
    }

}
