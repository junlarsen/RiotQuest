<?php

namespace RiotQuest\Tests\Endpoints;

use PHPUnit\Framework\TestCase;
use RiotQuest\Client;
use RiotQuest\Components\Collections\ShardStatus;
use RiotQuest\Contracts\LeagueException;

/**
 * Class StatusTest
 * @package RiotQuest\Tests\Endpoints
 */
class StatusTest extends TestCase
{

    /**
     * Test the status endpoint
     *
     * @throws LeagueException
     */
    public function testRequestShard()
    {
        $collection = Client::status('euw')->shard();

        $this->assertInstanceOf(ShardStatus::class, $collection);
    }

}
