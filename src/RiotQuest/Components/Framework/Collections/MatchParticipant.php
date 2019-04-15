<?php

namespace RiotQuest\Components\Framework\Collections;

use RiotQuest\Components\DataProvider\DataDragon\Dragon;
use RiotQuest\Components\Framework\Utils\Champion;
use RiotQuest\Components\Framework\Utils\Game;
use RiotQuest\Constants;

/**
 * Class MatchParticipant
 *
 * @see https://developer.riotgames.com/api-methods/#match-v4/GET_getMatch
 *
 * @property ParticipantStats $stats Stats for participant
 * @property int $participantId ID of player
 * @property RuneList $runes Old runes list
 * @property ParticipantTimeline $timeline
 * @property int $teamId Team of player
 * @property int $spell1Id Left summoner spell ID
 * @property int $spell2Id Right summoner spell ID
 * @property MasteryList $masteries Old masteries list
 * @property string $highestAchievedSeasonTier Highest tier achieved this season
 * @property int $championId Champion ID of player
 *
 * @todo spell icons
 *
 * @package RiotQuest\Components\Framework\Collections
 */
class MatchParticipant extends Collection
{

    /**
     * Get the BLUE or RED name of team
     *
     * @return string
     */
    public function getTeamName()
    {
        return Game::translateTeam($this->teamId);
    }

    /**
     * Get the champion icon URL
     *
     * @return string
     */
    public function getChampionIcon()
    {
        return Dragon::getChampionSquare($this->championId);
    }

    /**
     * Get the champion name
     *
     * @return string
     */
    public function getChampionName()
    {
        return Constants::champion()->getChampionName($this->championId);
    }

}
