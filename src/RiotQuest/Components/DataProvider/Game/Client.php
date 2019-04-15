<?php

namespace RiotQuest\Components\DataProvider\Game;

class Client
{

    public static function champion()
    {
        return new Champion();
    }

}
