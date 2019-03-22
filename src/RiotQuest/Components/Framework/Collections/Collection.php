<?php

namespace RiotQuest\Components\Framework\Collections;

use ArrayAccess;
use ArrayIterator;
use IteratorAggregate;
use Countable;
use Serializable;

class Collection implements
    ArrayAccess,
    Countable,
    IteratorAggregate,
    Serializable
{

    private $stack = [];

    public function __construct($stack)
    {
        $this->stack = $stack;
    }

    public function count()
    {
        return count($this->stack);
    }

    public function offsetGet($offset)
    {
        return $this->stack[$offset] ?? null;
    }

    public function offsetSet($offset, $value)
    {
        $this->stack[$offset] = $value;
        return $this;
    }

    public function offsetUnset($offset)
    {
        unset($this->stack[$offset]);
    }

    public function offsetExists($offset)
    {
        return isset($this->stack[$offset]);
    }

    public function getIterator()
    {
        return new ArrayIterator($this->stack);
    }

    public function serialize()
    {
        return \serialize($this->stack);
    }

    public function unserialize($serialized)
    {
        return \unserialize($serialized);
    }

}