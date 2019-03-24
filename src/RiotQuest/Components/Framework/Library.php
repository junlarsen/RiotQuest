<?php

namespace RiotQuest\Components\Framework;

use ReflectionClass;

/**
 * Class Library
 *
 * Performs basic actions for compiling resources
 *
 * @package RiotQuest\Components\Framework
 */
class Library
{

    /**
     * Retrieve a template for traversing through with a load
     * based on class.
     *
     * @param $reflector
     * @return array
     * @throws \ReflectionException
     */
    public static function template($reflector)
    {
        $ref = new ReflectionClass($reflector);
        // Match something like [ @property boolean $prop ]
        $ex = '/(@property ([\w\[\]]+) \$([\w]+))/m';
        preg_match_all($ex, $ref->getDocComment(), $matches, 1);
        $combined = [];
        foreach ($matches[3] as $key => $value) {
            $combined[$value] = $matches[2][$key];
        }
        foreach ($combined as $key => $value) {
            if (!in_array($value, ['int', 'boolean', 'float', 'double', 'array', 'string', 'bool', 'integer'])) {
                $combined[$key] = static::template("\\RiotQuest\\Components\\Framework\\Collections\\" . $value);
            }
        }
        $combined['_class'] = $reflector;
        return $combined;
    }

    /**
     * Iterates over a load (typically an API  response) with a given
     * template and assigns values to the collection type passed in the
     * template.
     *
     * @param $load
     * @param $template
     * @return mixed
     */
    public static function traverse($load, $template)
    {
        $collection = new $template['_class'];

        foreach ($load as $key => $value) {
            if (is_array($template[$key])) {
                $collection->put($key, static::traverse($value, $template[$key]));
            } else {
                switch ($template[$key]) {
                    case 'string':
                        $value = (string) $value; break;
                    case 'int':
                    case 'integer':
                        $value = (int) $value; break;
                    case 'double':
                    case 'float':
                        $value = (double) $value; break;
                    case 'bool':
                    case 'boolean':
                        $value = (bool) $value; break;
                }
                $collection->put($key, $value);
            }
        }

        return $collection;
    }

}
