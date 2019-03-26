<?php

namespace RiotQuest\Docs;

use Jenssegers\Blade\Blade;

class Generator

//TODO: megareflector
{

    /**
     * @var Blade
     */
    public $blade;

    public $files = [];

    public $vars = [];

    public $out = __DIR__ . '/out';

    public function __construct()
    {
        $this->blade = new Blade(__DIR__ . '/layouts', __DIR__ . '/cache');
        $files = scandir(__DIR__ . '/../src/RiotQuest/Components/Framework/Collections');
        array_shift($files);
        array_shift($files);
        $this->files = array_map(function ($e) {
            return str_replace('.php', '', $e);
        }, $files);
    }

    public function make()
    {
        foreach ($this->files as $file) {
            $this->vars[] = $def = new Definition($file, "\\RiotQuest\\Components\\Framework\\Collections\\");

            $render = $this->blade->make('collection', ['class' => $def]);
            file_put_contents($this->out . '/' . $def->dashed . '.md', $render);
        }
    }

}
