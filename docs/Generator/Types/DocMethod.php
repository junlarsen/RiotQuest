<?php

namespace RiotQuest\Docs\Generator\Types;

use ReflectionMethod;

class DocMethod
{

    public $reflector;

    public $parameters;

    public $name;

    public $type;

    public $parent;

    public $defined;

    public $synopsis;

    public $desc;

    public $paramsText = ' void ';

    public function __construct(ReflectionMethod $method, $parent)
    {
        $this->parent = $parent;
        $this->reflector = $method;
        $this->enable();
    }


    public function enable()
    {
        $this->defined = $this->reflector->getDeclaringClass();
        $this->name = $this->reflector->getName();

        preg_match('/@return (.+)/', $this->reflector->getDocComment(), $matches);
        $this->type = trim($matches[1] ?? 'void', PHP_EOL);

        $this->desc = preg_replace_callback('/@.+/', function () {
            return '';
        }, $this->reflector->getDocComment());
        $this->desc = trim(str_replace(['*', '/'], '', $this->desc));

        foreach ($this->reflector->getParameters() as $parameter) {
            $this->parameters[] = new DocParameter($parameter);
        }

        $this->synopsis = sprintf("public %s::%s( ",
            array_reverse(explode('\\', $this->reflector->class))[0],
            $this->name
        );
        if($this->parameters) {
            $map = array_map(function (DocParameter $parameter) {
                return $parameter->synopsis;
            }, $this->parameters);
            $this->paramsText = implode(', ', $map);
            $this->synopsis .= implode(', ', $map);
        } else {
            $this->synopsis .= 'void';
        }
        $this->synopsis .= ' ): ' . str_replace(PHP_EOL, '', $this->type);
    }
}
