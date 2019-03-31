<?php

namespace RiotQuest\Components\Framework\Engine;

/**
 * Class Filesystem
 *
 * Minimal abstraction for interacting with filesystem related
 * files when working with RiotQuest
 *
 * @package RiotQuest\Components\Framework\Engine
 */
class Filesystem
{

    /**
     * Input namespaces
     *
     * @var array
     */
    public static $namespaces = [
        'collections' => '\\RiotQuest\\Components\\Framework\\Collections\\'
    ];

    /**
     * Input directories
     *
     * @var array
     */
    public static $in = [
        'collections' => __DIR__ . '/../Collections/'
    ];

    /**
     * Output directories
     *
     * @var array
     */
    public static $out = [
        'collections' => __DIR__ . '/../../../../storage/templates/'
    ];

    /**
     * Generates the Collection templates
     *
     * @throws \ReflectionException
     */
    public function generateTemplates()
    {
        @mkdir(__DIR__ . '/../../../../storage/templates', 755);
        array_map(function ($file) {
            if ($file == '.' || $file == '..') return;
            $file = str_replace('.php', '', $file);
            file_put_contents(static::$out['collections'] . strtolower($file) . '.json', json_encode(Library::template(static::$namespaces['collections'] . $file)));
        }, scandir(static::$in['collections']));
        file_put_contents(static::$out['collections'] . '/manifest.json', json_encode(['time' => time()]));
    }

    /**
     * Deletes every saved template inside the template directory
     */
    public function flushTemplates()
    {
        array_map('unlink', glob(static::$out['collections'] . '*.json'));
    }

    /**
     * Get from file in cache
     *
     * @param $path
     * @return false|string
     */
    public static function getCacheFile($path)
    {
        @touch(__DIR__ . '/../../../../storage/cache/' . $path);
        return file_get_contents(__DIR__ . '/../../../../storage/cache/' . $path);
    }

    /**
     * Insert into file in cache
     *
     * @param $path
     * @param $data
     * @return bool|int
     */
    public static function putCacheFile($path, $data)
    {
        return file_put_contents(__DIR__ . '/../../../../storage/cache/' . $path, $data);
    }

}

