<?php

namespace RiotQuest\Components\Endpoints;

use Psr\Cache\InvalidArgumentException;
use RiotQuest\Components\Collections\ShardStatus;
use RiotQuest\Components\Engine\Request;
use RiotQuest\Contracts\LeagueException;

/**
 * Class League
 *
 * Platform to perform all LOL Status V4 related calls.
 *
 * @package RiotQuest\Components\Riot\Endpoints
 */
class Status extends Template
{

    /**
     * @see https://developer.riotgames.com/api-methods/#lol-status-v3/GET_getShardData
     *
     * @return ShardStatus
     * @throws LeagueException
     * @throws InvalidArgumentException
     */
    public function shard(): ShardStatus
    {
        return Request::create()
            ->with('destination', 'https://{region}.api.riotgames.com/lol/status/v3/shard-data')
            ->with('ttl', $this->ttl)
            ->with('function', 'status.shard')
            ->with('region', $this->region)
            ->send();
    }

}
