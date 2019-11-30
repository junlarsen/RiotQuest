<?php

namespace RiotQuest\Components\Collections;

/**
 * Class MiniSeries
 *
 * @see https://developer.riotgames.com/api-methods/#league-v4/GET_getAllLeaguePositionsForSummoner
 *
 * @property string $progress Progression in series, like WLNNN where W = win, L = loss and N = not played
 * @property int $losses Losses in miniseries
 * @property int $target
 * @property int $wins Wins in miniseries
 *
 * @package RiotQuest\Components\Framework\Collections
 */
class MiniSeries extends Collection
{

    /**
     * Turn the WLN format into true, false and nulls
     *
     * @return array
     */
    public function getParsedSeries()
    {
        return array_map(fn ($e) => $e == 'W' ? true : ($e == 'L' ? false : null), str_split($this->progress));
    }

}
