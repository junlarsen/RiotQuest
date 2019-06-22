<?php

namespace RiotQuest\Components\Collections;

/**
 * Class ChampionInfo
 *
 * @see https://developer.riotgames.com/api-methods/#champion-v3/GET_getChampionInfo
 *
 * @property IntList $freeChampionIdsForNewPlayers List of champions that are free for level < 10 players
 * @property IntList $freeChampionIds List of champions that are free for everybody else
 * @property int $maxNewPlayerLevel Threshold to keep the forNewPlayers rotation
 *
 * @package RiotQuest\Components\Framework\Collections
 */
class ChampionInfo extends Collection
{

    /**
     * Get a collection of combined lists
     *
     * @return Collection
     */
    public function getCombinedList()
    {
        return new Collection([
            'veteran' => $this->freeChampionIds,
            'new' => $this->freeChampionIdsForNewPlayers
        ]);
    }

}
