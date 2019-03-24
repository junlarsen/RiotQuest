<?php

namespace RiotQuest\Components\Riot\Endpoints;

use RiotQuest\Components\Http\Request;

/**
 * Class Summoner
 *
 * Platform to request all Summoner V4 related calls.
 *
 * @package RiotQuest\Components\Riot\Endpoints
 */
class Summoner extends Template
{

    public function account($id)
    {
        return Request::make(['summoner', __FUNCTION__])
            ->useStandard()
            ->setDestination('https://{region}.api.riotgames.com/lol/summoner/v4/summoners/by-account/{id}')
            ->setMethod('GET')
            ->setArguments(['region' => $this->region, 'id' => $id])
            ->setTtl($this->ttl)
            ->compile()
            ->send();
    }

    public function name($id)
    {
        return Request::make(['summoner', __FUNCTION__])
            ->useStandard()
            ->setDestination('https://{region}.api.riotgames.com/lol/summoner/v4/summoners/by-name/{id}')
            ->setMethod('GET')
            ->setArguments(['region' => $this->region, 'id' => $id])
            ->setTtl($this->ttl)
            ->compile()
            ->send();
    }

}
