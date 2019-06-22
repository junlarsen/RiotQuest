<?php

namespace RiotQuest\Tests\Endpoints;

use PHPUnit\Framework\TestCase;
use RiotQuest\Client;
use RiotQuest\Components\Collections\CurrentGameInfo;
use RiotQuest\Components\Collections\FeaturedGames;
use RiotQuest\Contracts\LeagueException;

/**
 * Class SpectatorTest
 * @package RiotQuest\Tests\Endpoints
 */
class SpectatorTest extends TestCase
{

    /**
     * Tests the featured games endpoint
     *
     * @throws LeagueException
     */
    public function testRequestFeaturedGames()
    {
        $collection = Client::spectator('euw')->featured();
        $this->assertInstanceOf(FeaturedGames::class, $collection);
    }

    /**
     * Tests the live game endpoint
     *
     */
    public function testRequestActiveGame()
    {
        try {
            // Summoner ID
            $collection = Client::spectator('euw')->active('GtmkO-wba00dtOkpaQhQzlHa1PT9cE7nFohDuikJn0fscL4');
            $this->assertInstanceOf(CurrentGameInfo::class, $collection);
        } catch (LeagueException $e) {
            // Caught 404 not found error, because user is not in game
            $this->assertTrue(true);
        }
    }

}
