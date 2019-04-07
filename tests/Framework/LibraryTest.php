<?php

namespace RiotQuest\Tests\Framework;

use PHPUnit\Framework\TestCase;
use RiotQuest\Components\Framework\Engine\Library;

class LibraryTest extends TestCase
{

    /**
     * Tests that loading a template returns an array
     */
    public function testTemplateLoad()
    {
        $this->assertIsArray(Library::loadTemplate('summoner'));
    }

    /**
     * Tests that region aliasing works
     */
    public function testRegionNames()
    {
        $this->assertEquals('euw1', Library::resolveRegion('euw'));
        $this->assertEquals('eun1', Library::resolveRegion('eune'));
        $this->assertEquals('na1', Library::resolveRegion('na'));
    }

    /**
     * Tests that replacing {strings] with array items works
     */
    public function testStringReplacement()
    {
        $string = '{name} is a nice person.';
        $this->assertEquals('supergrecko is a nice person.', Library::replace($string, ['name' => 'supergrecko']));
    }

}
