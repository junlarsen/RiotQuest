<?php

namespace RiotQuest\Tests\Collections;

use PHPUnit\Framework\TestCase;
use RiotQuest\Components\Framework\Collections\MatchParticipantList;
use RiotQuest\Components\Framework\Collections\MatchTimeline;
use RiotQuest\Components\Framework\Collections\ParticipantIdentityList;
use RiotQuest\Components\Framework\Collections\TeamStatsList;
use RiotQuest\Components\Framework\Mock\Mock;

class MatchTest extends TestCase
{

    /**
     * Test the different sub collection types
     */
    public function testCorrectTypes()
    {
        $match = Mock::createCollectionMock('Match');

        $this->assertInstanceOf(ParticipantIdentityList::class, $match->participantIdentities);
        $this->assertInstanceOf(TeamStatsList::class, $match->teams);
        $this->assertInstanceOf(MatchParticipantList::class, $match->participants);
    }

    /**
     * Tests timeline function
     */
    public function testGetTimeline()
    {
        $match = Mock::createCollectionMock('Match');
        $this->assertInstanceOf(MatchTimeline::class, $match->getTimeline());
    }

    /**
     * Test relative time stamp
     */
    public function testRelativeStartTime()
    {
        $match = Mock::createCollectionMock('Match');
        $this->assertIsInt($match->getRelativeStartTimeMs());
    }

}
