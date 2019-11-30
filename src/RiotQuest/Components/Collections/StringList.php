<?php

namespace RiotQuest\Components\Collections;

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
     * Runs str to lower on each element
     *
     * @return StringList
     */
    public function toLowerCase()
    {
        return new static($this->map(fn ($e) => strtolower($e)));
    }

    /**
     * Runs str to upper on each element
     *
     * @return StringList
     */
    public function toUpperCase()
    {
        return new static($this->map(fn ($e) => strtoupper($e)));
    }

}
