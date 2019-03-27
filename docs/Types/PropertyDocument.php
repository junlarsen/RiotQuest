<?php

namespace RiotQuest\Docs\Types;

use ReflectionProperty;

class PropertyDocument
{

    public $name;

    public $type;

    public function __construct($property)
    {
        if ($property instanceof ReflectionProperty) {
            $this->name = $property->getName();
            preg_match('/@var (\w+)/', $property->getDocComment(), $matches) ;
            $this->type = $matches[1];
        } else {
            $this->name = $property['name'];
            $this->type = $property['type'];
        }
    }

}