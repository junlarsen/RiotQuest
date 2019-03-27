<?php

namespace RiotQuest\Components\Framework\Collections;

/**
 * Class CurrentGameParticipant
 *
 * @see https://developer.riotgames.com/api-methods/#spectator-v4/GET_getCurrentGameInfoBySummoner
 *
 * @property double $profileIconId Summoner Icon ID
 * @property double $championId Champion ID which player is playing
 * @property string $summonerName Summoner name of player
 * @property GameCustomizationObjectList $gameCustomizationObjects Game customization objects
 * @property boolean $bot Is player a bot?
 * @property Perks $perks Current runes summoner is using
 * @property double $spell1Id Spell slot one ID
 * @property double $spell2Id Spell slot two ID
 * @property double $teamId Team ID for player
 * @property string $summonerId Summoner ID of player
 *
 * @package RiotQuest\Components\Framework\Collections
 */
class CurrentGameParticipant extends Collection
{



}
