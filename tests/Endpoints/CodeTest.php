<?php

namespace RiotQuest\Tests\Endpoints;

use PHPUnit\Framework\TestCase;
use RiotQuest\Client;
use RiotQuest\Contracts\LeagueException;

/**
 * Class CodeTest
 * @package RiotQuest\Tests\Endpoints
 */
class CodeTest extends TestCase
{

    /**
     * Assert that the code endpoint works
     *
     * @throws LeagueException
     */
    public function testRequestCode()
    {
        // Summoner ID
        $code = Client::code('euw')->id('GtmkO-wba00dtOkpaQhQzlHa1PT9cE7nFohDuikJn0fscL4');

        $this->assertTrue($code === null || gettype($code) === "string");
    }

}
