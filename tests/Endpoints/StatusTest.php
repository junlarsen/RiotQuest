<?php

namespace RiotQuest\Tests\Endpoints;

use PHPUnit\Framework\TestCase;
use RiotQuest\Client;
use RiotQuest\Components\Collections\ShardStatus;

Client::boot();

class StatusTest extends TestCase
{

    /**
     * Test the status endpoint
     *
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Psr\SimpleCache\InvalidArgumentException
     * @throws \ReflectionException
     * @throws \RiotQuest\Contracts\LeagueException
     */
    public function testRequestShard()
    {
        $collection = Client::status('euw')->shard();

        $this->assertInstanceOf(ShardStatus::class, $collection);
    }

}
