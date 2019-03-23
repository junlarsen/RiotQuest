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

    public function name($name)
    {
        return Request::make(['summoner', __FUNCTION__])
            ->useStandard()
            ->setDestination('https://{region}.api.riotgames.com/lol/summoner/v4/summoners/by-name/{name}')
            ->setMethod('GET')
            ->setArguments(['region' => $this->region, 'name' => $name])
            ->compile()
            ->send()
            ->collect();
    }

}
