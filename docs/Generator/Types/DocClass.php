<?php

namespace RiotQuest\Docs\Generator\Types;

use ReflectionClass;

class DocClass
{

    public $reflector;

    public $properties = [];

    public $methods;

    public $name;

    public $short;

    public $namespace;

    public $parentClass;

    public $dashed;

    public $ref;

    public function __construct(ReflectionClass $class)
    {
        $this->reflector = $class;
        $this->enable();
    }

    /**
     * Populates the class with reflection properties
     */
    public function enable()
    {
        // Basic property assignment
        $this->name = $this->reflector->getName();
        $this->namespace = $this->reflector->getNamespaceName();
        $this->short = $this->reflector->getShortName();

        // Parent Class generation
        if ($this->reflector->getParentClass()) {
            $this->parentClass = new self($this->reflector->getParentClass());
        }

        $this->dashed = trim(preg_replace_callback('/([A-Z])/m', function ($matches) {
            return "-$matches[0]";
        }, $this->short), '-');

        preg_match('/@see (.+)/', $this->reflector->getDocComment(), $matches);
        $this->ref = $matches[1] ?? '#';

        preg_match_all('/(@property ([\w\[\]]+) \$([\w]+)( [. \w]*)?)/', $this->reflector->getDocComment(), $matches);
        foreach ($matches[3] as $key => $value) {
            $this->properties[] = new DocProperty($matches[3][$key], $matches[2][$key], $matches[4][$key] ?? '');
        }

        // Methods
        foreach ($this->reflector->getMethods() as $method)
        {
            $this->methods[] = new DocMethod($method, $this);
        }
    }

}
