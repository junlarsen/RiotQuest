<?php

namespace RiotQuest\Components\Framework\Endpoints;

use GuzzleHttp\Exception\GuzzleException;
use Psr\SimpleCache\InvalidArgumentException;
use ReflectionException;
use RiotQuest\Components\Framework\Collections\ShardStatus;
use RiotQuest\Components\Framework\Engine\Request;
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
     * @throws GuzzleException
     * @throws InvalidArgumentException
     * @throws ReflectionException
     * @throws LeagueException
     */
    public function shard(): ShardStatus
    {
        return Request::make(['status', __FUNCTION__])
            ->useStandard()
            ->setDestination('https://{region}.api.riotgames.com/lol/status/v3/shard-data')
            ->setMethod('GET')
            ->setArguments(['region' => $this->region])
            ->setTtl($this->ttl)
            ->compile()
            ->sendRequest();
    }

}
