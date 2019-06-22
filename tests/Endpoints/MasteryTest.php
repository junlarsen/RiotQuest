<?php

namespace RiotQuest\Tests\Endpoints;

use PHPUnit\Framework\TestCase;
use RiotQuest\Client;
use RiotQuest\Components\Collections\ChampionMastery;
use RiotQuest\Components\Collections\ChampionMasteryList;
use RiotQuest\Contracts\LeagueException;

/**
 * Class MasteryTest
 * @package RiotQuest\Tests\Endpoints
 */
class MasteryTest extends TestCase
{

    /**
     * Tests the all masteries endpoint
     *
     * @throws LeagueException
     */
    public function testRequestAllMasteries()
    {
        // Summoner ID
        $collection = Client::mastery('euw')->all('GtmkO-wba00dtOkpaQhQzlHa1PT9cE7nFohDuikJn0fscL4');

        $this->assertInstanceOf(ChampionMasteryList::class, $collection);
    }

    /**
     * Tests the single mastery endpoint
     *
     * @throws LeagueException
     */
    public function testRequestSingleMastery()
    {
        // Summoner ID
        $collection = Client::mastery('euw')->id('GtmkO-wba00dtOkpaQhQzlHa1PT9cE7nFohDuikJn0fscL4', 1);

        $this->assertInstanceOf(ChampionMastery::class, $collection);
    }

    /**
     * Test total mastery score endpoint
     *
     * @throws LeagueException
     */
    public function testRequestTotalScore()
    {
        // Summoner ID
        $collection = Client::mastery('euw')->score('GtmkO-wba00dtOkpaQhQzlHa1PT9cE7nFohDuikJn0fscL4');

        $this->assertTrue(gettype($collection) === 'integer');
    }

}
