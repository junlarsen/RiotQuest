<?php

namespace RiotQuest\Components\Collections;

/**
 * Class ParticipantTimeline
 *
 * @see https://developer.riotgames.com/api-methods/#match-v4/GET_getMatch
 *
 * @property string $lane Which lane player was in
 * @property int $participantId Participant ID of player
 * @property IntList $csDiffPerMinDeltas List of cs per minute differences
 * @property IntList $goldPerMinDeltas List of gold per minute
 * @property IntList $xpDiffPerMinDeltas List of xp diff per minute differences
 * @property IntList $creepsPerMinDeltas List of jungle creeps per minute
 * @property IntList $xpPerMinDeltas List of xp per minute
 * @property string $role Role player was in
 * @property IntList $damageTakenDiffPerMinDeltas Damage taken per minute differences
 * @property IntList $damageTakenPerMinDeltas Damage taken mer minute
 *
 * @package RiotQuest\Components\Framework\Collections
 */
class ParticipantTimeline extends Collection
{


}
