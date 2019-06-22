<?php

namespace RiotQuest\Tests\Endpoints;

use PHPUnit\Framework\TestCase;
use RiotQuest\Client;
use RiotQuest\Components\Collections\ChampionInfo;

Client::boot();

class ChampionTest extends TestCase
{

    /**
     * Test the champion rotations endpoint
     *
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Psr\SimpleCache\InvalidArgumentException
     * @throws \ReflectionException
     * @throws \RiotQuest\Contracts\LeagueException
     */
    public function testRequestRotation()
    {
        $collection = Client::champion('euw')->rotation();

        $this->assertInstanceOf(ChampionInfo::class, $collection);
    }

}
