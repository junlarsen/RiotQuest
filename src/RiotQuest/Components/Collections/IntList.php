<?php

namespace RiotQuest\Components\Collections;

/**
 * Class IntList
 *
 * @see https://www.php.net/manual/en/language.types.integer.php
 *
 * @list int
 *
 * @package RiotQuest\Components\Framework\Collections
 */
class IntList extends Collection
{

    /**
     * Returns average of list
     *
     * @return float|int
     */
    public function getAverage(): int
    {
        $c = 0;
        foreach ($this as $num) {
            $c += $num;
        }
        return $c / count($this);
    }

    /**
     * Returns sum of all items
     *
     * @return float|int
     */
    public function getSum(): int
    {
        return array_sum($this->items);
    }

}
