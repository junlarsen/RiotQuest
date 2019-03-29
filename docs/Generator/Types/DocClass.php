<?php

namespace RiotQuest\Docs\Generator\Types;

use ReflectionClass;

/**
 * Class DocClass
 *
 * A DocClass represents a class which has a bunch of properties.
 *
 * @package RiotQuest\Docs\Generator\Types
 */
class DocClass
{

    /**
     * ReflectionClass of this class
     *
     * @var ReflectionClass
     */
    public $reflector;

    /**
     * List of properties for this class
     *
     * @var array
     */
    public $properties = [];

    /**
     * List of methods for this class
     *
     * @var array
     */
    public $methods;

    /**
     * Class Name with namespace
     *
     * @var string
     */
    public $name;

    /**
     * Shortname for this class
     *
     * @var string
     */
    public $short;

    /**
     * Namespace
     *
     * @var string
     */
    public $namespace;

    /**
     * Parent class
     *
     * @var DocClass
     */
    public $parentClass;

    /**
     * Dashed name for class
     *
     * @var string
     */
    public $dashed;

    /**
     * Reference link to view
     *
     * @var string
     */
    public $ref;

    /**
     * DocClass constructor.
     * @param ReflectionClass $class
     */
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

        // Turn name into Dashed-name
        $this->dashed = trim(preg_replace_callback('/([A-Z])/m', function ($matches) {
            return "-$matches[0]";
        }, $this->short), '-');

        // @see Link
        preg_match('/@see (.+)/', $this->reflector->getDocComment(), $matches);
        $this->ref = $matches[1] ?? '#';

        // Doc Comment properties
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
