<?php

namespace RiotQuest\Docs;

class Definition
{

    public $name;

    public $spaced;

    public $dashed;

    public $props = [];

    public $methods;

    public $interfaces;

    public $extensions;

    public $link;

    public function __construct($class, $namespace)
    {
        $reflector = new \ReflectionClass($namespace . $class);
        $this->name = $class;

        $this->spaced = preg_replace_callback('/([A-Z])/', function ($matches) {
            return " $matches[0]";
        }, $class);

        $this->dashed = trim(preg_replace_callback('/([A-Z])/', function ($matches) {
            return "-$matches[0]";
        }, $class), '-');

        $this->methods = $reflector->getMethods();

        preg_match_all('/(@property ([\w\[\]]+) \$([\w]+))/', $reflector->getDocComment(), $matches);
        foreach ($matches[3] as $key => $value) {
            $this->props[$value] = $matches[2][$key];
        }
    }

}
