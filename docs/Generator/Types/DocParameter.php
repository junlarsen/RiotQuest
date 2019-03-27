<?php

namespace RiotQuest\Docs\Generator\Types;

use ReflectionParameter;

class DocParameter
{

    public $reflector;

    public $name;

    public $default;

    public $type;

    public $synopsis;

    public function __construct(ReflectionParameter $parameter)
    {
        $this->reflector = $parameter;
        $this->enable();
    }

    public function enable()
    {
        $this->name = $this->reflector->getName();
        $this->type = $this->reflector->getType() ?? 'any';
        if ($this->reflector->isDefaultValueAvailable()) {
            $this->default = $this->reflector->getDefaultValue() !== [] ? $this->reflector->getDefaultValue() : false;
        } else {
            $this->default = false;
        }
        $this->synopsis = sprintf("%s $%s",
            $this->type,
            $this->name
        );

        if ($this->default !== false) {
            $this->synopsis .= " = $this->default";
        }
    }

}
