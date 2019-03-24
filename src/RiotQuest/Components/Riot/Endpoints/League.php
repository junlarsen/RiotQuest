<?php

namespace RiotQuest\Components\Riot\Endpoints;

use RiotQuest\Components\Http\Request;

/**
 * Class League
 *
 * Platform to perform all League V4 related calls.
 *
 * @package RiotQuest\Components\Riot\Endpoints
 */
class League extends Template
{

    public function positions($id)
    {
        return Request::make(['league', __FUNCTION__])
            ->useStandard()
            ->setDestination('https://{region}.api.riotgames.com/lol/league/v4/positions/by-summoner/{id}')
            ->setMethod('GET')
            ->setArguments(['region' => $this->region, 'id' => $id])
            ->setTtl($this->ttl)
            ->compile()
            ->send();
    }

    public function id($id)
    {
        return Request::make(['league', __FUNCTION__])
            ->useStandard()
            ->setDestination('https://{region}.api.riotgames.com/lol/league/v4/leagues/{id}')
            ->setMethod('GET')
            ->setArguments(['region' => $this->region, 'id' => $id])
            ->setTtl($this->ttl)
            ->compile()
            ->send();
    }

}
