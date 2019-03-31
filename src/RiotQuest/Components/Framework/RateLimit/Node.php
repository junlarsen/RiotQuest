<?php

namespace RiotQuest\Components\Framework\RateLimit;

use Serializable;

class Node implements Serializable
{

    private $node = [];

    public function __construct($limit, $timeout)
    {
        $this->node = [
            'time' => $timeout,
            'limit' => $limit,
            'count' => 0
        ];
    }

    public function setTime($ttl = 0)
    {
        $this->node['time'] = (float) $ttl;
    }

    public function addCount($count = 1)
    {
        $this->node['count'] += $count;
    }

    public function isAlive()
    {
        return time() < $this->node['time'];
    }

    public function setLimit($limit)
    {
        $this->node['limit'] = $limit;
    }

    public function getNode()
    {
        return $this->node;
    }

    public function serialize()
    {
        return \serialize($this->node);
    }

    public function unserialize($serialized)
    {
        $this->node = unserialize($serialized);
    }

}
