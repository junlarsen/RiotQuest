<?php

namespace RiotQuest\Tests\Framework;

use PHPUnit\Framework\TestCase;
use RiotQuest\Client;
use RiotQuest\Components\Engine\Utils;

Client::boot();

class LibraryTest extends TestCase
{

    /**
     * Tests that loading a template returns an array
     */
    public function testTemplateLoad()
    {
        $this->assertIsArray(Utils::loadTemplate('summoner'));
    }

    /**
     * Tests that region aliasing works
     */
    public function testRegionNames()
    {
        $this->assertEquals('euw1', Utils::resolveRegion('euw'));
        $this->assertEquals('eun1', Utils::resolveRegion('eune'));
        $this->assertEquals('na1', Utils::resolveRegion('na'));
    }

    /**
     * Tests that replacing {strings] with array items works
     */
    public function testStringReplacement()
    {
        $string = '{name} is a nice person.';
        $this->assertEquals('supergrecko is a nice person.', Utils::replace($string, ['name' => 'supergrecko']));
    }

}
