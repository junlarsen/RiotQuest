<?php

namespace RiotQuest\Docs\Types;

use ReflectionClass;

class ClassDocument
{

    public $name;

    public $methods = [];

    public $full;

    public $doc;

    public $props;

    public $link;

    public function __construct(ReflectionClass $class)
    {
        $this->name = $class->name;
        $this->full = $class->getName();
        foreach ($class->getMethods() as $method) {
            $this->methods[$method->name] = new MethodDocument($method, $this);
        }
        foreach ($class->getProperties() as $property) {
            $this->props[$property->name] = new PropertyDocument($property);
        }
        $this->doc = $class->getDocComment();
        preg_match_all('/(@property ([\w\[\]]+) \$([\w]+))/', $this->doc, $matches);
        foreach ($matches[3] as $key => $value) {
            $this->props[$value] = new PropertyDocument(['type' => $matches[2][$key], 'name' => $matches[3][$key]]);
        }
    }

}
