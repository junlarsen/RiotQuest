<?php

namespace RiotQuest\Components\Framework\Collections;

/**
 * Class ChampionMastery
 *
 * @see https://developer.riotgames.com/api-methods/#champion-mastery-v4/GET_getChampionMastery
 *
 * @property boolean $chestGranted Has a chest been earned this season for this champion?
 * @property int $championLevel Mastery level on champion: 1-7
 * @property int $championPoints Number of points on champion
 * @property double $championId The champion ID
 * @property double $championPointsUntilNextLevel Points until next mastery level
 * @property double $lastPlayTime Unix Timestamp of last playtime
 * @property int $tokensEarned Mastery tokens earned towards graduation
 * @property double $championPointsSinceLastLevel Points earned since last level
 * @property string $summonerId The summoner ID
 *
 * @package RiotQuest\Components\Framework\Collections
 */
class ChampionMastery extends Collection
{



}
