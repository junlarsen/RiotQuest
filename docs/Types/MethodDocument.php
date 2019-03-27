<?php

namespace RiotQuest\Docs\Types;

use ReflectionMethod;
use ReflectionClass;

class MethodDocument
{

    public $method;

    public $name;

    public $args = [];

    public $parentName;

    public $inheritance;

    public $inheritanceName;

    public $synopsis;

    public function __construct(ReflectionMethod $method, ClassDocument $document)
    {
        $this->method = $method;
        $this->name = $method->name;
        $this->args = $method->getParameters();
        $this->parentName = $document->name;
        $this->inheritance = $method->getDeclaringClass()->getName() === $document->full ? $method->getDeclaringClass() : false;
        $this->inheritanceName = $method->getDeclaringClass()->getName();
        $this->makeSynopsis();
    }

    public function makeSynopsis()
    {
        $st = array_reverse(explode('\\', isset($this->inheritance->name) ? $this->parentName : $this->inheritanceName ))[0] . '::';
        $st .= $this->name;
        $st .= ':' . $this->method->getReturnType();
        $this->synopsis = $st;
    }

}
