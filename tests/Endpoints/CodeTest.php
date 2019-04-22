<?php

namespace RiotQuest\Tests\Endpoints;

use PHPUnit\Framework\TestCase;
use RiotQuest\Client;

Client::boot();

class CodeTest extends TestCase
{

    /**
     * Assert that the code endpoint works
     *
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Psr\SimpleCache\InvalidArgumentException
     * @throws \ReflectionException
     * @throws \RiotQuest\Contracts\LeagueException
     */
    public function testRequestCode()
    {
        // Summoner ID
        $code = Client::code('euw')->id('GtmkO-wba00dtOkpaQhQzlHa1PT9cE7nFohDuikJn0fscL4');

        $this->assertTrue($code === null || gettype($code) === "string");
    }

}
