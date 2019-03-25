<?php

namespace RiotQuest\Components\Framework;

use function foo\func;
use ReflectionClass;
use RiotQuest\Components\Framework\Collections\ChampionInfo;
use RiotQuest\Components\Framework\Collections\ChampionMastery;
use RiotQuest\Components\Framework\Collections\ChampionMasteryList;
use RiotQuest\Components\Framework\Collections\League;
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
     *
     * TODO: single value response collections
     */
    public static $returnTypes = [
        'mastery' => [
            'all' => ChampionMasteryList::class,
            'id' => ChampionMastery::class,
            'score' => false
        ],
        'champion' => [
            'rotation' => ChampionInfo::class
        ],
        'league' => [
            'positions' => LeaguePositionList::class,
            'id' => League::class,
            'grandmaster',
            'challenger',
            'master'
        ],
        'status' => [
            'shard'
        ],
        'match' => [
            'tournamentList',
            'id',
            'tournament',
            'list',
            'timeline'
        ],
        'spectator' => [
            'featured',
            'active'
        ],
        'summoner' => [
            'name' => Summoner::class,
            'account' => Summoner::class,
            'id' => Summoner::class,
            'unique' => Summoner::class
        ],
        'code' => [
            'id'
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

    public static function template($class)
    {
        $template = [];
        $ref = new ReflectionClass($class);
        if (strpos($class, 'List')) {
            preg_match('/(@list ([\w]+))/m', $ref->getDocComment(), $matches);
            if (!in_array($matches[2], ['int', 'boolean', 'double', 'array', 'string'])) {
                $template['_list'] = static::template("\\RiotQuest\\Components\\Framework\\Collections\\" . $matches[2]);
            } else {
                $template['_list'] = $matches[2];
            }
        } else {
            preg_match_all('/(@property ([\w\[\]]+) \$([\w]+))/m', $ref->getDocComment(), $matches);
            foreach ($matches[3] as $key => $value) {
                $template[$value] = $matches[2][$key];
            }
            foreach ($template as $key => $value) {
                if (!in_array($value, ['int', 'boolean', 'double', 'array', 'string'])) {
                    $template[$key] = static::template("\\RiotQuest\\Components\\Framework\\Collections\\" . $value);
                }
            }
        }
        $template['_class'] = $class;
        return $template;
    }

    public static function traverse($data, $template)
    {
        $col = new $template['_class'];
        if (isset($template['_list'])) {
            foreach ($data as $key => $value) {
                if (isset($template['_list']['_class'])) {
                    $co = static::traverse($value, $template['_list']);
                    $col->put($key, $co);
                } else {
                    $col->put($key, $value);
                }
            }
        } else {
            foreach ($data as $key => $value) {
                if (is_array($template[$key])) {
                    $co = static::traverse($value, $template[$key]);
                    $col->put($key, $co);
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
                    $col->put($key, $value);
                }
            }
        }
        return $col;
    }

}
