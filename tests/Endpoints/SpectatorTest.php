<?php

namespace RiotQuest\Tests\Endpoints;

use PHPUnit\Framework\TestCase;
use RiotQuest\Client;
use RiotQuest\Components\Framework\Collections\CurrentGameInfo;
use RiotQuest\Components\Framework\Collections\FeaturedGames;

class SpectatorTest extends TestCase
{

    /**
     * Tests the featured games endpoint
     *
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Psr\SimpleCache\InvalidArgumentException
     * @throws \ReflectionException
     * @throws \RiotQuest\Contracts\RiotQuestException
     */
    public function testRequestFeaturedGames()
    {
        $collection = Client::spectator('euw')->featured();
        $this->assertInstanceOf(FeaturedGames::class, $collection);
    }

    /**
     * Tests the live game endpoint
     *
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Psr\SimpleCache\InvalidArgumentException
     * @throws \ReflectionException
     * @throws \RiotQuest\Contracts\RiotQuestException
     */
    public function testRequestActiveGame()
    {
        $collection = Client::spectator('euw')->active('GtmkO-wba00dtOkpaQhQzlHa1PT9cE7nFohDuikJn0fscL4');

        $this->assertTrue($collection === null || $collection instanceof CurrentGameInfo);
    }

}
