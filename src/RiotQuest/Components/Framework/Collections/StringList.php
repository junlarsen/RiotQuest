<?php

namespace RiotQuest\Components\Framework\Collections;

/**
 * Class StringList
 *
 * @see https://www.php.net/manual/en/language.types.string.php
 *
 * @list string
 *
 * @package RiotQuest\Components\Framework\Collections
 */
class StringList extends Collection
{

    /**
     * Runs strtolower on each element
     *
     * @return StringList
     */
    public function toLowerCase()
    {
        return new static($this->map(function ($e) {
            return strtolower($e);
        }));
    }

    /**
     * Runs strtoupper on each element
     *
     * @return StringList
     */
    public function toUpperCase()
    {
        return new static($this->map(function ($e) {
            return strtoupper($e);
        }));
    }

}
