<?php

namespace RiotQuest\Components\Endpoints;

use RiotQuest\Components\Engine\Request;
use RiotQuest\Contracts\LeagueException;

/**
 * Class League
 *
 * Platform to perform all Third Party Code V4 related calls.
 *
 * @package RiotQuest\Components\Riot\Endpoints
 */
class Code extends Template
{

    /**
     * @see https://developer.riotgames.com/api-methods/#third-party-code-v4/GET_getThirdPartyCodeBySummonerId
     *
     * @param $id
     * @return string
     * @throws LeagueException
     */
    public function id(string $id)
    {
        return Request::make(['code', __FUNCTION__])
            ->useStandard()
            ->setDestination('https://{region}.api.riotgames.com/lol/platform/v4/third-party-code/by-summoner/{id}')
            ->setMethod('GET')
            ->setArguments(['region' => $this->region, 'id' => $id])
            ->setTtl($this->ttl)
            ->compile()
            ->sendRequest();
    }

}
