<?php

namespace RiotQuest\Components\Framework\Collections;

/**
 * Class IntList
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
    public function avg()
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
    public function sum()
    {
        return array_sum($this->stack);
    }

}
