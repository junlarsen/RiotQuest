<?php

namespace RiotQuest\Components\Collections;

use Carbon\Carbon;
use Carbon\CarbonInterface;

/**
 * Class FeaturedGameInfo
 *
 * @see https://developer.riotgames.com/api-methods/#spectator-v4/GET_getFeaturedGames
 *
 * @property double $gameId Game ID for this game
 * @property double $gameStartTime Unix timestamp of when this game started
 * @property string $platformId Platform game is being played on
 * @property string $gameMode Game mode game is being played
 * @property double $mapId Map game is being played on
 * @property string $gameType Game type of game
 * @property BannedChampionList $bannedChampions Banned champions in this game
 * @property Observer $observers Observers for this game
 * @property ParticipantList $participants List of participants in game
 * @property double $gameLength Length game has been going for
 * @property double $gameQueueConfigId Queue ID of game
 *
 * @package RiotQuest\Components\Framework\Collections
 */
class FeaturedGameInfo extends Collection
{

    /**
     * Get Carbon instance for start time
     *
     * @return Carbon|CarbonInterface
     */
    public function getStartTime()
    {
        return Carbon::createFromTimestamp($this->gameStartTime);
    }

    /**
     * Get relative start time
     *
     * @return int
     */
    public function getRelativeStartTimeMs()
    {
        return Carbon::now()->diffInMilliseconds(Carbon::createFromTimestampMs($this->gameStartTime));
    }

    /**
     * Get the observer key
     *
     * @return string
     */
    public function getObserverKey()
    {
        return $this->observers->encryptionKey;
    }

    /**
     * Get the banned champion
     *
     * @return array
     */
    public function getBannedChampionIds()
    {
        return $this->bannedChampions->getListIds();
    }

}
