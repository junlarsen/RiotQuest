<?php

namespace RiotQuest\Components\Framework\Collections;

use ArrayAccess;
use ArrayIterator;
use IteratorAggregate;
use Countable;
use Serializable;
use Closure;

/**
 * Class Collection
 *
 * @see https://github.com/supergrecko/RiotQuest/wiki/Return-Types
 *
 * Definition which each DTO extends to make working with
 * API responses easier and more flexible
 *
 * @package RiotQuest\Components\Framework\Collections
 */
class Collection implements
    ArrayAccess,
    Countable,
    IteratorAggregate,
    Serializable
{

    /**
     * The items in the stack
     * @var array
     */
    protected $stack = [];

    /**
     * Create a new Collection
     *
     * @param array $stack
     */
    public function __construct($stack = [])
    {
        $this->stack = $stack;
    }

    /**
     * Adds a key and value pair into collection
     *
     * @param $key
     * @param $value
     */
    public function put($key, $value)
    {
        $this->stack[$key] = $value;
    }

    /**
     * Gets all the items
     *
     * @return array
     */
    public function all()
    {
        return $this->stack;
    }

    /**
     * Merges two stacks
     *
     * @param array $stack
     * @return Collection
     */
    public function merge($stack = [])
    {
        return new static(array_merge($this->stack, $stack));
    }

    /**
     * Json encodes the stack
     *
     * @return false|string
     */
    public function json()
    {
        return \json_encode($this->stack);
    }

    /**
     * Performs array_key_exists on collection
     *
     * @param $key
     * @return bool
     */
    public function exists($key)
    {
        return isset($this->stack[$key]);
    }

    /**
     * Runs a foreach on collection calling Closure each time
     *
     * @param Closure $closure
     * @return $this
     */
    public function each(Closure $closure)
    {
        foreach ($this->stack as $key => $item) {
            if (!($closure->call($this, $item, $key))) {
                break;
            }
        }
        return $this;
    }

    /**
     * Performs an array_filter on collection
     *
     * @param Closure $closure
     * @return array
     */
    public function filter(Closure $closure)
    {
        return array_filter($this->stack, $closure);
    }

    /**
     * Get array keys for collection
     *
     * @return array
     */
    public function keys()
    {
        return array_keys($this->stack);
    }

    /**
     * Performs an array_map on collection
     *
     * @param Closure $closure
     * @return array
     */
    public function map(Closure $closure)
    {
        return array_map($closure, $this->stack);
    }

    /**
     * Count of items in array
     *
     * @param int $recursive
     * @return int
     */
    public function count($recursive = 0)
    {
        return \count($this->stack, $recursive);
    }

    /**
     * ArrayAccess implementation
     *
     * @param mixed $offset
     * @return mixed|null
     */
    public function offsetGet($offset)
    {
        return $this->stack[$offset] ?? null;
    }

    /**
     * ArrayAccess implementation
     *
     * @param mixed $offset
     * @param mixed $value
     */
    public function offsetSet($offset, $value)
    {
        $this->stack[$offset] = $value;
    }

    /**
     * ArrayAccess implementation
     *
     * @param mixed $offset
     */
    public function offsetUnset($offset)
    {
        unset($this->stack[$offset]);
    }

    /**
     * ArrayAccess implementation
     *
     * @param mixed $offset
     * @return bool
     */
    public function offsetExists($offset)
    {
        return isset($this->stack[$offset]);
    }

    /**
     * ArrayIterator implementation
     *
     * @return ArrayIterator|\Traversable
     */
    public function getIterator()
    {
        return new ArrayIterator($this->stack);
    }

    /**
     * Serializes the stack
     *
     * @return string
     */
    public function serialize()
    {
        return \serialize($this->stack);
    }

    /**
     * Unserialize a stack
     *
     * @param string $serialized
     * @return mixed|void
     */
    public function unserialize($serialized)
    {
        return \unserialize($serialized);
    }

}