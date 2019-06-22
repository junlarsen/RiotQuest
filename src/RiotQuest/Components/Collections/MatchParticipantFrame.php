<?php

namespace RiotQuest\Components\Collections;

/**
 * Class MatchParticipantFrame
 *
 * @see https://developer.riotgames.com/api-methods/#match-v4/GET_getMatchTimeline
 *
 * @property int $totalGold Amount of gold player has at this time
 * @property int $teamScore Team score ( dominion etc. )
 * @property int $participantId Participant ID for player
 * @property int $level Ingame level at this time ( 1-18 )
 * @property int $currentGold How much gold the player has
 * @property int $minionsKilled How many minions killed
 * @property int $dominionScore Individual dominion score
 * @property MatchPosition $position Location on map
 * @property int $xp Total experience gained
 * @property int $jungleMinionsKilled Jungle creeps killed
 *
 * @package RiotQuest\Components\Framework\Collections
 */
class MatchParticipantFrame extends Collection
{


}
