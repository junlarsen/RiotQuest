<?php

namespace RiotQuest\Tests\Framework;

use PHPUnit\Framework\TestCase;
use RiotQuest\Client;
use RiotQuest\Components\Framework\Engine\Filesystem;

Client::boot();

class TemplateTest extends TestCase
{

    /**
     * Test that the collection template works
     *
     * @throws \ReflectionException
     */
    public function testTemplateGeneration()
    {
        (new Filesystem())->generateTemplates();
        $this->assertFileExists(__DIR__ . '/../../src/storage/templates/manifest.json');
    }

    /**
     * Tests that wiping all the templates works
     */
    public function testTemplateFlush()
    {
        (new Filesystem())->flushTemplates();
        $this->assertFileNotExists(__DIR__ . '/../../src/storage/templates/manifest.json');
    }

}
