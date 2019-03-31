<?php

namespace RiotQuest\Components\Framework\Collections;

use Carbon\Carbon;

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
     * @return Carbon|\Carbon\CarbonInterface
     */
    public function getStartTime()
    {
        return Carbon::createFromTimestamp($this->gameStartTime);
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

}
