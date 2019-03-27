<?php

namespace RiotQuest\Docs;

use foo\bar;
use Jenssegers\Blade\Blade;
use ReflectionClass;
use RiotQuest\Docs\Types\ClassDocument;

class Generator

//TODO: megareflector
{

    public $documentors = [
        'collections' => [],
        'endpoints' => []
    ];

    public static $map = [
        'collections' => [
            '\\RiotQuest\\Components\\Framework\\Collections\\',
            'src/RiotQuest/Components/Framework/Collections'
        ],
        'endpoints' => [
            '\\RiotQuest\\Components\\Framework\\Endpoints\\',
            'src/RiotQuest/Components/Framework/Endpoints'
        ]
    ];

    public $reflectors = [
        'collections' => [],
        'endpoints' => []
    ];

    public function __construct()
    {
        foreach (scandir(static::$map['collections'][1]) as $file) {
            if ($file == '.' || $file == '..') continue;
            $name = str_replace('.php', '', $file);
            $this->reflectors['collections'][$name] = new ReflectionClass(static::$map['collections'][0] . $name);
        }

        foreach (scandir(static::$map['endpoints'][1]) as $file) {
            if ($file == '.' || $file == '..') continue;
            $name = str_replace('.php', '', $file);
            $this->reflectors['endpoints'][$name] = new ReflectionClass(static::$map['endpoints'][0] . $name);
        }
    }

    public function collections()
    {
        #foreach ($this->reflectors['collections'] as $key => $reflector) {
        #    $this->documentors['collections'][$key] = new ClassDocument($reflector);
        #}
        $this->documentors['collections']['LeaguePositionList'] = new ClassDocument($this->reflectors['collections']['LeaguePositionList']);
    }

    public function endpoints()
    {
        #foreach ($this->reflectors['endpoints'] as $key => $reflector) {
        #    $this->documentors['endpoints'][$key] = new ClassDocument($reflector);
        #}
    }

}
