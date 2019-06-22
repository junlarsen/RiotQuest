<?php

namespace RiotQuest\Tests\Endpoints;

use PHPUnit\Framework\TestCase;
use RiotQuest\Client;
use RiotQuest\Components\Collections\ChampionInfo;
use RiotQuest\Contracts\LeagueException;

/**
 * Class ChampionTest
 * @package RiotQuest\Tests\Endpoints
 */
class ChampionTest extends TestCase
{

    /**
     * Test the champion rotations endpoint
     *
     * @throws LeagueException
     */
    public function testRequestRotation()
    {
        $collection = Client::champion('euw')->rotation();

        $this->assertInstanceOf(ChampionInfo::class, $collection);
    }

}
