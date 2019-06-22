<?php

namespace RiotQuest\Components\Collections;

use RiotQuest\Components\DataProviders\Provider;

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
     * Get the champion icon URL
     *
     * @return string
     */
    public function getChampionIcon()
    {
        return Provider::getChampionSquare($this->championId);
    }

    /**
     * Get the champion name
     *
     * @return string
     */
    public function getChampionName()
    {
        return Provider::getChampionName($this->championId);
    }

}
