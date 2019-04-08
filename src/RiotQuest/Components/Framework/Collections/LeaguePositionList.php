<?php

namespace RiotQuest\Components\Framework\Collections;

/**
 * Class LeaguePositionList
 *
 * @see https://developer.riotgames.com/api-methods/#league-v4/GET_getAllLeaguePositionsForSummoner
 *
 * @list LeaguePosition
 *
 * @package RiotQuest\Components\Framework\Collections
 */
class LeaguePositionList extends Collection
{

    /**
     * Get the SoloQ LeaguePosition
     *
     * @return LeaguePosition
     */
    public function getSoloQueue()
    {
        return array_filter($this->stack, function (LeaguePosition $e) {
            return $e->queueType === 'RANKED_SOLO_5x5';
        })[0];
    }

    /**
     * Get the 3v3 LeaguePosition
     *
     * @return LeaguePosition
     */
    public function getFlexTreeline()
    {
        return array_filter($this->stack, function (LeaguePosition $e) {
            return $e->queueType === 'RANKED_FLEX_SR';
        })[0];
    }

    /**
     * Get the 5v5 LeaguePosition
     *
     * @return LeaguePosition
     */
    public function getFlexRift()
    {
        return array_filter($this->stack, function (LeaguePosition $e) {
            return $e->queueType === 'RANKED_FLEX_TT';
        })[0];
    }

    /**
     * Get the queues this user is ranked in
     *
     * @return StringList
     */
    public function getRankedQueues()
    {
        return new StringList(array_values(array_map(function (LeaguePosition $e) {
            return $e->queueType;
        }, $this->stack)));
    }

}
