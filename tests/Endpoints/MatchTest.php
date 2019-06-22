<?php

namespace RiotQuest\Tests\Endpoints;

use PHPUnit\Framework\TestCase;
use RiotQuest\Client;
use RiotQuest\Components\Collections\Match;
use RiotQuest\Components\Collections\MatchHistory;
use RiotQuest\Components\Collections\MatchTimeline;

Client::boot();

class MatchTest extends TestCase
{

    /**
     * Tests match by id endpoint
     *
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Psr\SimpleCache\InvalidArgumentException
     * @throws \ReflectionException
     * @throws \RiotQuest\Contracts\LeagueException
     */
    public function testRequestSingleId()
    {
        // Match ID
        $collection = Client::match('euw')->id(3982997035);

        $this->assertInstanceOf(Match::class, $collection);
    }

    /**
     * Tests the match history endpoint
     *
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Psr\SimpleCache\InvalidArgumentException
     * @throws \ReflectionException
     * @throws \RiotQuest\Contracts\LeagueException
     */
    public function testRequestMatchList()
    {
        // Account ID
        $collection = Client::match('euw')->list('BfLfuDhG64nRnrs4f-mjHwWlk4iXTadzgixzxah_GzbI3Lk');

        $this->assertInstanceOf(MatchHistory::class, $collection);
    }

    /**
     * Tests the match timeline endpoint
     *
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Psr\SimpleCache\InvalidArgumentException
     * @throws \ReflectionException
     * @throws \RiotQuest\Contracts\LeagueException
     */
    public function testRequestTimeline()
    {
        // Match ID
        $collection = Client::match('euw')->timeline(3982997035);

        $this->assertInstanceOf(MatchTimeline::class, $collection);
    }

}
