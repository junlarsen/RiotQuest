<?php

namespace RiotQuest\Components\Framework\Templater;

use League\Flysystem\Adapter\Local;
use League\Flysystem\Filesystem;
use ReflectionClass;

class Templater {

    public static function generateSingle(string $class) {
        $template = [];
        $ref = new ReflectionClass($class);
        if (strpos($class, 'List')) {
            preg_match('/(@list ([\w]+))/m', $ref->getDocComment(), $matches);
            if (!in_array($matches[2], ['int', 'boolean', 'double', 'array', 'string'])) {
                $template['_list'] = static::generateSingle("\\RiotQuest\\Components\\Framework\\Collections\\" . $matches[2]);
            } else {
                $template['_list'] = $matches[2];
            }
        } else {
            preg_match_all('/(@property ([\w\[\]]+) \$([\w]+))/', $ref->getDocComment(), $matches);
            foreach ($matches[3] as $key => $value) {
                $template[$value] = $matches[2][$key];
            }
            foreach ($template as $key => $value) {
                if (!in_array($value, ['int', 'boolean', 'double', 'array', 'string'])) {
                    $template[$key] = static::generateSingle("\\RiotQuest\\Components\\Framework\\Collections\\" . $value);
                }
            }
        }
        $template['_class'] = $class;
        return $template;
    }

    public static function generateAll() {
        $in = new Filesystem(new Local(__DIR__ . '/../Collections/'));
        $out = new Filesystem(new Local(__DIR__ . '/../../../../storage/'));

        $out->deleteDir("templates");
        $out->createDir("templates");

        foreach ($in->listContents() as $file) {
            if ($file['type'] === 'file') {
                $out->write("templates/" . strtolower($file['filename']) . ".json", json_encode(static::generateSingle("\\RiotQuest\\Components\\Framework\\Collections\\" . $file['filename'])));
            }
        }
    }
    
}
