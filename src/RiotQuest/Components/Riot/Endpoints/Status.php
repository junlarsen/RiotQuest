<?php

namespace RiotQuest\Components\Riot\Endpoints;

use RiotQuest\Components\Http\Request;

/**
 * Class League
 *
 * Platform to perform all LOL Status V4 related calls.
 *
 * @package RiotQuest\Components\Riot\Endpoints
 */
class Status extends Template
{

    public function shard()
    {
        return Request::make(['status', __FUNCTION__])
            ->useStandard()
            ->setDestination('https://{region}.api.riotgames.com/lol/status/v3/shard-data')
            ->setMethod('GET')
            ->setArguments(['region' => $this->region])
            ->setTtl($this->ttl)
            ->compile()
            ->send();
    }

}
