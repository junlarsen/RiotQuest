<?php

namespace RiotQuest\Components\Framework\Utils;

class Game
{

    /**
     * Turns either 100 or 200 into RED and BLUE
     *
     * @param $id
     * @return string
     */
    public static function translateTeam(int $id)
    {
        return $id === 100 ? 'BLUE' : 'RED';
    }

}
