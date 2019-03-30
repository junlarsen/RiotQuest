<?php

namespace RiotQuest\Components\Framework\Collections;

/**
 * Class MatchEvent
 *
 * @see https://developer.riotgames.com/api-methods/#match-v4/GET_getMatchTimeline
 *
 * @property string $eventType Which type of event this was
 * @property string $towerType If tower related event, which tower type
 * @property int $teamId Team which got this event
 * @property string $ascendedType Ascension type if ascension
 * @property int $killerId Killer participant ID, if any
 * @property string $levelUpType Level up type, if levelup event
 * @property string $pointCaptured Ascension point ID which was captured
 * @property IntList $assistingParticipantIds All other participants which took part of this event
 * @property string $wardType Ward type, if ward event
 * @property string $monsterType Monster type, if monster event
 * @property string $type Event type
 * @property int $skillSlot Skill slot used, if skill event
 * @property int $victimId If the event happened against another player, which participant ID
 * @property double $timestamp Timestamp of event
 * @property int $afterId
 * @property string $monsterSubType Monster sub type, if monster event
 * @property string $laneType Lane type, if lane event
 * @property int $itemId Item id, if item event
 * @property int $participantId Participant which triggered this event
 * @property string $buildingType Building type, if building related event
 * @property int $creatorId
 * @property MatchPosition $position Location on map where event occurred
 * @property int $beforeId
 *
 * @package RiotQuest\Components\Framework\Collections
 */
class MatchEvent extends Collection
{



}
