<?php

namespace RiotQuest\Docs\Generator\Types;

class DocProperty
{

    public $name;

    public $type;

    public $synopsis;

    public $desc;

    public function __construct($name, $type, $desc)
    {
        $this->desc = $desc;
        $this->type = $type;
        $this->name = $name;
        $this->enable();
    }

    public function enable()
    {
        $this->synopsis = "public $this->name: $this->type";
    }

}
