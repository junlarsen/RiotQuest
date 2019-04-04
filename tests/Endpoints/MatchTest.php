<?php

namespace RiotQuest\Tests\Endpoints;

use PHPUnit\Framework\TestCase;
use RiotQuest\Client;
use RiotQuest\Components\Framework\Collections\Match;
use RiotQuest\Components\Framework\Collections\MatchHistory;
use RiotQuest\Components\Framework\Collections\MatchTimeline;

class MatchTest extends TestCase
{

    /**
     * Tests match by id endpoint
     *
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Psr\SimpleCache\InvalidArgumentException
     * @throws \ReflectionException
     * @throws \RiotQuest\Contracts\RiotQuestException
     */
    public function testRequestSingleId()
    {
        $collection = Client::match('euw')->id(3982997035);

        $this->assertInstanceOf(Match::class, $collection);
    }

    /**
     * Tests the match history endpoint
     *
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Psr\SimpleCache\InvalidArgumentException
     * @throws \ReflectionException
     * @throws \RiotQuest\Contracts\RiotQuestException
     */
    public function testRequestMatchList()
    {
        $collection = Client::match('euw')->list('BfLfuDhG64nRnrs4f-mjHwWlk4iXTadzgixzxah_GzbI3Lk');

        $this->assertInstanceOf(MatchHistory::class, $collection);
    }

    /**
     * Tests the match timeline endpoint
     *
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Psr\SimpleCache\InvalidArgumentException
     * @throws \ReflectionException
     * @throws \RiotQuest\Contracts\RiotQuestException
     */
    public function testRequestTimeline()
    {
        $collection = Client::match('euw')->timeline(3982997035);

        $this->assertInstanceOf(MatchTimeline::class, $collection);
    }

}
