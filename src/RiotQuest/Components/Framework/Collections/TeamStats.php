<?php

namespace RiotQuest\Components\Framework\Collections;

/**
 * Class TeamStats
 *
 * @see https://developer.riotgames.com/api-methods/#match-v4/GET_getMatch
 *
 * @property boolean $firstDragon Did this team get first dragon?
 * @property boolean $firstInhibitor Did this team get the first inhibitor?
 * @property TeamBansList $bans List of champions this team banned
 * @property int $baronKills Amount of barons killed by team
 * @property boolean $firstRiftHerald Did this team kill the first (if multiple) rift herald?
 * @property boolean $firstBaron Did this team kill the first baron?
 * @property int $riftHeraldKills Amount of rift heralds killed by team
 * @property int $teamId Team ID
 * @property boolean $firstBlood Did this team get first blood?
 * @property boolean $firstTower Did this team get first tower?
 * @property int $vilemawKills Amount of vilemaws killed by team
 * @property int $inhibitorKills Amount of inhibitors taken down by team
 * @property int $towerKills Amount of towers taken down by team
 * @property int $dominionVictoryScore Victory score in dominion
 * @property string $win Did this team win or not? ( WIN or FAIL )
 * @property int $dragonKills Amount of dragons killed by team
 *
 * @package RiotQuest\Components\Framework\Collections
 */
class TeamStats extends Collection
{

    /**
     * Returns the team win result as a bool
     *
     * @return bool
     */
    public function getWinBoolean()
    {
        return $this->win == 'WIN';
    }

}
