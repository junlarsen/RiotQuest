<?php

namespace RiotQuest\Tests\Endpoints;

use PHPUnit\Framework\TestCase;
use RiotQuest\Client;
use RiotQuest\Components\Collections\Match;
use RiotQuest\Components\Collections\MatchHistory;
use RiotQuest\Components\Collections\MatchTimeline;
use RiotQuest\Contracts\LeagueException;

/**
 * Class MatchTest
 * @package RiotQuest\Tests\Endpoints
 */
class MatchTest extends TestCase
{

    /**
     * Tests match by id endpoint
     *
     * @throws LeagueException
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
     * @throws LeagueException
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
     * @throws LeagueException
     */
    public function testRequestTimeline()
    {
        // Match ID
        $collection = Client::match('euw')->timeline(3982997035);

        $this->assertInstanceOf(MatchTimeline::class, $collection);
    }

}
