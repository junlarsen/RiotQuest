<?php

namespace RiotQuest\Components\Framework\Endpoints;

use RiotQuest\Components\Framework\Engine\Request;

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
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Psr\SimpleCache\InvalidArgumentException
     * @throws \ReflectionException
     * @throws \RiotQuest\Contracts\RiotQuestException
     */
    public function id($id)
    {
        return Request::make(['code', __FUNCTION__])
            ->useStandard()
            ->setDestination('https://{region}.api.riotgames.com/lol/platform/v4/third-party-code/by-summoner/{id}')
            ->setMethod('GET')
            ->setArguments(['region' => $this->region, 'id' => $id])
            ->setTtl($this->ttl)
            ->compile()
            ->send();
    }

}
