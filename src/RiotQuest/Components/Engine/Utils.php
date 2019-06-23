<?php

namespace RiotQuest\Components\Engine;

use RiotQuest\Components\Collections\ChampionInfo;
use RiotQuest\Components\Collections\ChampionMastery;
use RiotQuest\Components\Collections\ChampionMasteryList;
use RiotQuest\Components\Collections\Collection;
use RiotQuest\Components\Collections\CurrentGameInfo;
use RiotQuest\Components\Collections\FeaturedGames;
use RiotQuest\Components\Collections\League;
use RiotQuest\Components\Collections\LeagueEntryList;
use RiotQuest\Components\Collections\Match;
use RiotQuest\Components\Collections\MatchHistory;
use RiotQuest\Components\Collections\MatchTimeline;
use RiotQuest\Components\Collections\ShardStatus;
use RiotQuest\Components\Collections\Summoner;

/**
 * Class Utils
 *
 * Performs basic actions for compiling resources
 *
 * @package RiotQuest\Components\Framework
 */
class Utils
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
        'na-old' => 'na',

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
     * The array value is the Collection subclass the
     * endpoint should load its data into. If value
     * is false, it should return the plain value
     *
     * @var array
     */
    public static $responses = [
        'mastery.all' => ChampionMasteryList::class,
        'mastery.id' => ChampionMastery::class,
        'mastery.score' => false,

        'champion.rotation' => ChampionInfo::class,

        'league.positions' => LeagueEntryList::class,
        'league.id' => League::class,
        'league.grandmaster' => League::class,
        'league.challenger' => League::class,
        'league.master' => League::class,
        'league.entries' => LeagueEntryList::class,

        'status.shard' => ShardStatus::class,

        'match.tournamentList' => false, // n/a
        'match.id' => Match::class,
        'match.tournament' => false, // n/a
        'match.list' => MatchHistory::class,
        'match.timeline' => MatchTimeline::class,
        'spectator.featured' => FeaturedGames::class,
        'spectator.active' => CurrentGameInfo::class,

        'summoner.name' => Summoner::class,
        'summoner.account' => Summoner::class,
        'summoner.id' => Summoner::class,
        'summoner.unique' => Summoner::class,

        'code.id' => false
    ];

    /**
     * The loaded templates from file
     *
     * @var array
     */
    static $templates = [];

    /**
     * Load template from file and save into memory
     *
     * @param $path
     * @return mixed
     */
    public static function loadTemplate(string $path)
    {
        $path = strtolower(array_reverse(explode('\\', $path))[0]) . '.json';

        if (!isset(static::$templates[$path])) {
            $template = json_decode(file_get_contents(__DIR__ . '/../../../storage/templates/' . $path), 1);
            static::$templates[$path] = $template;
        }

        return static::$templates[$path];
    }

    /**
     * Matches given region against the static map. Returns the match if the subject matches any of the aliases.
     * Returns false if no replacement was found.
     *
     * @param $region
     * @return string|false
     */
    public static function resolveRegion(string $region)
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
     * @return string|null
     */
    public static function replace(string $subject, array $replace = [])
    {
        return preg_replace_callback('/\{(\w+)\}/', function ($matches) use ($replace) {
            return $replace[$matches[1]] ?? '';
        }, $subject);
    }

    /**
     * Fills a skeleton from static::template with the data
     * from $data.
     *
     * @param $data
     * @param $template
     * @param $region
     * @return mixed
     */
    public static function traverse($data, array $template, string $region)
    {
        $primitives = ['int', 'integer', 'string', 'bool', 'boolean', 'double', 'array'];
        /** @var Collection $col */

        $col = new $template['class'];
        $col->setRegion($region);

        if (!empty($template['list'])) {
            if (in_array($template['list'][0], $primitives)) {
                foreach ((array)$data as $key => $value) {
                    $col->put($key, $value);
                }
            } else {
                $temp = static::loadTemplate($template['list'][0]);

                foreach ((array)$data as $key => $value) {
                    $col->put($key, static::traverse($value, $temp, $region));
                }
            }
        } else {
            foreach ((array)$data as $key => $value) {
                $type = $template['props']['$' . $key];

                if (in_array($type, $primitives)) {
                    settype($value, $type);
                    $col->put($key, $value);
                } else {
                    $temp = static::loadTemplate($template['props']['$' . $key]);
                    $col->put($key, static::traverse($value, $temp, $region));
                }
            }
        }

        return $col;
    }

}
