<?php

namespace RiotQuest\Components\Framework\Collections;

use Illuminate\Support\Collection as Module;

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
class Collection extends Module {

    protected $region;

    public function __construct($items = [], $region = null)
    {
        parent::__construct($items);
        $this->region = $region;
    }

    public function setRegion(string $region) {
        $this->region = $region;
    }

    public function __get($key)
    {
        return $this->items[$key] ?? null;
    }

}
