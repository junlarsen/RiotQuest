<?php

namespace RiotQuest\Tests\Collections;

use PHPUnit\Framework\TestCase;
use RiotQuest\Client;
use RiotQuest\Components\Framework\Collections\Collection;
use RiotQuest\Components\Framework\Collections\Match;

Client::boot();

class CollectionTest extends TestCase
{

    /**
     * Test whether any collection extends the base collection class
     */
    public function testCollectionInheritance()
    {
        $comparison = new Match();
        $this->assertInstanceOf(Collection::class, $comparison);
    }

}
