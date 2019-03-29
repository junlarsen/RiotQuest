<?php

namespace RiotQuest\Components\Framework\Engine;

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
        foreach (scandir(static::$in['collections']) as $file) {
            if ($file == '.' || $file == '..') continue;
            $file = str_replace('.php', '', $file);
            file_put_contents(static::$out['collections'] . strtolower($file) . '.json', json_encode(Library::template(static::$namespaces['collections'] . $file)));
        }
        file_put_contents(static::$out['collections'] . '/manifest.json', json_encode(['time' => time()]));
    }

    public function flushTemplates()
    {
        array_map('unlink', glob(static::$out['collections'] . '*.json'));
    }

}

