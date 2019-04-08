<?php

namespace RiotQuest\Components\Framework\Collections;

use RiotQuest\Components\Framework\Utils\Game;

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

}
