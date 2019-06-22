<?php

namespace RiotQuest\Components\Collections;

/**
 * Class LeagueEntryList
 *
 * @see https://developer.riotgames.com/api-methods/#league-v4/GET_getLeagueEntriesForSummoner
 *
 * @list LeagueEntry
 *
 * @package RiotQuest\Tests\Collections
 */
class LeagueEntryList extends Collection
{

    /**
     * Get the SoloQ LeaguePosition
     *
     * @return LeagueEntry
     */
    public function getSoloQueue()
    {
        return array_filter($this->items, function (LeagueEntry $e) {
            return $e->queueType === 'RANKED_SOLO_5x5';
        })[0];
    }

    /**
     * Get the 3v3 LeaguePosition
     *
     * @return LeagueEntry
     */
    public function getFlexTreeline()
    {
        return array_filter($this->items, function (LeagueEntry $e) {
            return $e->queueType === 'RANKED_FLEX_SR';
        })[0];
    }

    /**
     * Get the 5v5 LeaguePosition
     *
     * @return LeagueEntry
     */
    public function getFlexRift()
    {
        return array_filter($this->items, function (LeagueEntry $e) {
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
        return new StringList(array_values(array_map(function (LeagueEntry $e) {
            return $e->queueType;
        }, $this->items)));
    }

}
