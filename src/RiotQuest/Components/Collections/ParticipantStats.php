<?php

namespace RiotQuest\Components\Collections;

/**
 * Class ParticipantStats
 *
 * @see https://developer.riotgames.com/api-methods/#match-v4/GET_getMatch
 *
 * @property boolean $firstBloodAssist Did user take part in the first blood?
 * @property double $visionScore Vision score for player that game
 * @property double $magicDamageDealtToChampions
 * @property double $damageDealtToObjectives Damage dealt to large monsters
 * @property int $totalTimeCrowdControlDealt Crowd control dealt, in seconds
 * @property int $longestTimeSpentLiving Longest time alive
 * @property int $nodeNeutralizeAssist
 * @property int $totalScoreRank
 * @property int $neutralMinionsKilled Jungle monsters killed
 * @property double $damageDealtToTurrets
 * @property double $physicalDamageDealtToChampions
 * @property int $nodeCapture
 * @property int $totalUnitsHealed
 * @property int $wardsKilled Amount of wards of any type killed
 * @property int $largestCriticalStrike
 * @property int $largestKillingSpree
 * @property int $teamObjective
 * @property double $magicDamageDealt
 * @property double $neutralMinionsKilledTeamJungle Jungle monsters killed in own jungle
 * @property double $damageSelfMitigated Self mitigated damage ( shields, armor, damage reduction )
 * @property boolean $firstInhibitorKill
 * @property double $trueDamageTaken
 * @property int $nodeNeutralize
 * @property int $combatPlayerScore
 * @property int $perkPrimaryStyle Primary rune path
 * @property int $goldSpent
 * @property double $trueDamageDealt
 * @property int $participantId Participant ID
 * @property double $totalDamageTaken
 * @property double $physicalDamageDealt
 * @property int $sightWardsBoughtInGame Control wards bought
 * @property double $totalDamageDealtToChampions
 * @property double $physicalDamageTaken
 * @property double $magicalDamageTaken
 * @property int $totalPlayerScore
 * @property boolean $win Did player win?
 * @property int $objectivePlayerScore
 * @property double $totalDamageDealt
 * @property int $neutralMinionsKilledEnemyJungle Jungle monsters killed in enemy jungle
 * @property int $wardsPlaced Amount of wards placed of any type
 * @property int $perkSubStyle Secondary rune path
 * @property int $turretKills Last hits on towers
 * @property boolean $firstBloodKill
 * @property double $trueDamageDealtToChampions
 * @property int $goldEarned
 * @property int $killingSprees
 * @property int $altarsCaptured Treeline altars captured
 * @property boolean $firstTowerAssist
 * @property boolean $firstTowerKill
 * @property int $champLevel End of game level
 * @property int $nodeCaptureAssist
 * @property int $inhibitorKills
 * @property boolean $firstInhibitorAssist
 * @property int $visionWardsBoughtInGame
 * @property int $altarsNeutralized
 * @property double $totalHeal
 * @property int $totalMinionsKilled
 * @property double $timeCCingOthers
 *
 * @property int $kills
 * @property int $doubleKills
 * @property int $tripleKills
 * @property int $quadraKills
 * @property int $pentaKills
 * @property int $largestMultiKill
 * @property int $assists
 * @property int $deaths
 * @property int $unrealKills Hexakills in Hexakill gamemode
 *
 * @property int $item0 Top left item
 * @property int $item1 Top middle item
 * @property int $item2 Top right item
 * @property int $item3 Bottom left item
 * @property int $item4 Bottom middle item
 * @property int $item5 Bottom right item
 * @property int $item6 Sight ward
 *
 * @property int $perk0 Keystone
 * @property int $perk1 Primary path #2
 * @property int $perk2 Primary path #3
 * @property int $perk3 Primary path #4
 * @property int $perk4 Secondary path #1
 * @property int $perk5 Secondary path #2
 *
 * @property int $statPerk0 Top row stat
 * @property int $statPerk1 Middle row stat
 * @property int $statPerk2 Bottom row stat
 *
 * @property int $perk0Var1 Keystone
 * @property int $perk0Var2
 * @property int $perk0Var3
 * @property int $perk1Var1 Primary path #2
 * @property int $perk1Var2
 * @property int $perk1Var3
 * @property int $perk2Var1 Primary path #3
 * @property int $perk2Var2
 * @property int $perk2Var3
 * @property int $perk3Var1 Primary path #4
 * @property int $perk3Var2
 * @property int $perk3Var3
 * @property int $perk4Var1 Secondary path #1
 * @property int $perk4Var2
 * @property int $perk4Var3
 * @property int $perk5Var1 Secondary path #2
 * @property int $perk5Var2
 * @property int $perk5Var3
 *
 * @property int $playerScore0 Dominion scores
 * @property int $playerScore1
 * @property int $playerScore2
 * @property int $playerScore3
 * @property int $playerScore4
 * @property int $playerScore5
 * @property int $playerScore6
 * @property int $playerScore7
 * @property int $playerScore8
 * @property int $playerScore9
 *
 * @todo runes reforged names
 * @package RiotQuest\Components\Framework\Collections
 */
class ParticipantStats extends Collection
{

    /**
     * Gets amount of multikills a player had
     *
     * @return int
     */
    public function getMultiKills()
    {
        return $this->unrealKills + $this->pentaKills + $this->quadraKills + $this->tripleKills + $this->doubleKills;
    }

    /**
     * Return how much of the earned gold a user spent
     *
     * @return float|int
     */
    public function getGoldUsage()
    {
        return ($this->goldSpent / $this->goldEarned) * 100;
    }

    /**
     * Get the total damage ddealt to champions
     *
     * @return array
     */
    public function getDamageToChampions()
    {
        return [
            'total' => $this->totalDamageDealtToChampions,
            'magic' => $this->magicDamageDealtToChampions,
            'physical' => $this->physicalDamageDealtToChampions,
            'true' => $this->trueDamageDealtToChampions
        ];
    }

    /**
     * Get the total damage dealt amounts
     *
     * @return array
     */
    public function getDamageAmounts()
    {
        return [
            'total' => $this->totalDamageDealt,
            'magic' => $this->magicDamageDealt,
            'physical' => $this->physicalDamageDealt,
            'true' => $this->trueDamageDealt
        ];
    }

    /**
     * Get player KDA as string
     *
     * @return string
     */
    public function getKDAString()
    {
        return "$this->kills / $this->deaths / $this->assists";
    }

    /**
     * Get player KDA as an array
     *
     * @return array
     */
    public function getKDAArray()
    {
        return [$this->kills, $this->deaths, $this->assists];
    }

    /**
     * Get the items as an array instead of indexing each property
     *
     * @return array
     */
    public function getItemList()
    {
        return [
            $this->item0 ?? 0,
            $this->item1 ?? 0,
            $this->item2 ?? 0,
            $this->item3 ?? 0,
            $this->item4 ?? 0,
            $this->item5 ?? 0,
            $this->item6 ?? 0
        ];
    }

}
