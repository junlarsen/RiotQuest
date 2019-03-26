<?php

namespace RiotQuest\Components\Framework\Collections;

/**
 * Class CurrentGameInfo
 *
 * @see https://developer.riotgames.com/api-methods/#spectator-v4/GET_getCurrentGameInfoBySummoner
 *
 * @property double $gameId
 * @property double $gameStartTime
 * @property string $platformId
 * @property string $gameMode
 * @property double $mapId
 * @property string $gameType
 * @property BannedChampionList $bannedChampions
 * @property Observer $observers
 * @property CurrentGameParticipantList $participants
 * @property double $gameLength
 * @property double $gameQueueConfigId
 *
 * @package RiotQuest\Components\Framework\Collections
 */
class CurrentGameInfo extends Collection
{



}
