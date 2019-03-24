<?php

namespace RiotQuest\Components\Framework;

use ReflectionClass;
use RiotQuest\Components\Framework\Collections\Summoner;
use RiotQuest\Components\Framework\Collections\LeaguePositionList;

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
     * Collection of Regions and region aliases
     *
     * @var array
     */
    public static $map = [
        'euw' => 'euw1',
        'euw1' => 'euw1',
        'eu-west' => 'euw1',
        'europe-west' => 'euw1',

        'eune' => 'eun1',
        'eune1' => 'eun1',
        'eu-nordic' => 'eun1',
        'europe-nordic' => 'eun1',

        'br' => 'br1',
        'br1' => 'br1',
        'brazil' => 'br1',

        'jp' => 'jp1',
        'jp1' => 'jp1',
        'japan' => 'japan',

        'kr' => 'kr',
        'kr1' => 'kr',
        'korea' => 'kr',

        'lan' => 'la1',
        'la1' => 'la1',
        'latin-america-north' => 'la1',
        'latin-north' => 'la1',

        'las' => 'la2',
        'la2' => 'la2',
        'latin-america-south' => 'la2',
        'latin-south' => 'la2',

        'na' => 'na1',
        'na1' => 'na1',
        'north-america' => 'na1',
        'na-og' => 'na',

        'oce' => 'oc1',
        'oc1' => 'oc1',
        'oceania' => 'oc1',

        'tr' => 'tr1',
        'tr1' => 'tr1',
        'turkey' => 'tr1',

        'ru' => 'ru',
        'ru1' => 'ru',
        'russia' => 'ru',

        'pbe' => 'pbe1',
        'pbe1' => 'pbe1',
        'player-beta-environment' => 'pbe1',
        'player-beta' => 'pbe1',

        'americas' => 'americas',
        'europe' => 'europe',
        'asia' => 'asia'
    ];

    /**
     * Return types for each endpoint
     *
     * @var array
     */
    public static $returnTypes = [
        'summoner' => [
            'name' => Summoner::class
        ],
        'league' => [
            'positions' => LeaguePositionList::class
        ]
    ];

    /**
     * Matches given region against the static map. Returns the match if the subject matches any of the aliases.
     * Returns false if no replacement was found.
     *
     * @param $region
     * @return bool|mixed
     */
    public static function region($region)
    {
        $region = strtolower(str_replace(' ', '-', $region));
        if (array_key_exists($region, static::$map)) {
            return static::$map[$region];
        }
        return false;
    }

    /**
     * Matches a string with { placeholders } and replaces
     * them by name with the $replace.
     *
     * @param $subject
     * @param $replace
     * @return string|string[]|null
     */
    public static function replace($subject, $replace)
    {
        return preg_replace_callback('/\{(\w+)\}/', function ($matches) use ($replace) {
            return $replace[$matches[1]];
        }, $subject);
    }

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
