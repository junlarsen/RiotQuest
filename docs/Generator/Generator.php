<?php

namespace RiotQuest\Docs\Generator;

use Jenssegers\Blade\Blade;
use ReflectionClass;
use RiotQuest\Docs\Generator\Types\DocClass;

/**
 * Class Generator
 *
 * Simple Reflection based generator for turning a class
 * into a markdown set using Blade's templates.
 *
 * @package RiotQuest\Docs\Generator
 */
class Generator
{

    /**
     * Reflection classes from documents
     *
     * @var array
     */
    public $documentors = [
        'collections' => []
    ];

    /**
     * 2D array for mapping Namespaces and dirs
     *
     * @var array
     */
    public static $map = [
        'collections' => [
            '\\RiotQuest\\Components\\Framework\\Collections\\',
            __DIR__ . '/../../src/RiotQuest/Components/Framework/Collections'
        ]
    ];

    /**
     * @var array
     */
    public $reflectors = [
        'collections' => [],
    ];

    /**
     * Blade template builder
     *
     * @var Blade
     */
    public $blade;

    /**
     * Generator constructor.
     *
     * @throws \ReflectionException
     */
    public function __construct()
    {
        $this->blade = new Blade(__DIR__ . '/../layouts', __DIR__ . '/../cache');
        foreach (scandir(static::$map['collections'][1]) as $file) {
            if ($file == '.' || $file == '..') continue;
            $name = str_replace('.php', '', $file);
            $this->reflectors['collections'][$name] = new ReflectionClass(static::$map['collections'][0] . $name);
        }
    }

    /**
     * Build the wiki sidebar
     */
    public function sidebar()
    {
        $render = $this->blade->make('sidebar', ['class' => $this->documentors]);
        file_put_contents(__DIR__ . '/../out/_Sidebar.md', $render);
    }

    /**
     * Build the wiki collections
     */
    public function collections()
    {
        foreach ($this->reflectors['collections'] as $key => $reflector) {
            $this->documentors['collections'][$key] = new DocClass($reflector);
        }

        foreach ($this->documentors['collections'] as $collection) {
            $render = $this->blade->make('collection', ['class' => $collection]);
            file_put_contents(__DIR__ . '/../out/' . $collection->dashed . '.md', $render);
        }
    }

}
