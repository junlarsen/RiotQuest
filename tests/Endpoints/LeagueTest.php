<?php

namespace RiotQuest\Tests\Endpoints;

use PHPUnit\Framework\TestCase;
use RiotQuest\Client;
use RiotQuest\Components\Framework\Collections\League;
use RiotQuest\Components\Framework\Collections\LeaguePositionList;

class LeagueTest extends TestCase
{

    /**
     * Test the single league ID endpoint
     *
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Psr\SimpleCache\InvalidArgumentException
     * @throws \ReflectionException
     * @throws \RiotQuest\Contracts\RiotQuestException
     */
    public function testRequestSingleLeague()
    {
        // League ID
        $collection = Client::league('euw')->id('159026101e0-2cb7-11e9-9a42-c81f66dd2a8f');

        $this->assertInstanceOf(League::class, $collection);
    }

    /**
     * Test the apex league endpoints
     *
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Psr\SimpleCache\InvalidArgumentException
     * @throws \ReflectionException
     * @throws \RiotQuest\Contracts\RiotQuestException
     */
    public function testRequestApexLeagues()
    {
        $collection1 = Client::league('euw')->challenger('RANKED_SOLO_5x5');
        $collection2 = Client::league('euw')->master('RANKED_SOLO_5x5');
        $collection3 = Client::league('euw')->grandmaster('RANKED_SOLO_5x5');

        $this->assertInstanceOf(League::class, $collection1);
        $this->assertInstanceOf(League::class, $collection2);
        $this->assertInstanceOf(League::class, $collection3);
    }

    /**
     * Test positions for summoner endpoint
     *
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Psr\SimpleCache\InvalidArgumentException
     * @throws \ReflectionException
     * @throws \RiotQuest\Contracts\RiotQuestException
     */
    public function testRequestPositions()
    {
        // Summoner ID
        $collection = Client::league('euw')->positions('GtmkO-wba00dtOkpaQhQzlHa1PT9cE7nFohDuikJn0fscL4');

        $this->assertInstanceOf(LeaguePositionList::class, $collection);
    }

}
