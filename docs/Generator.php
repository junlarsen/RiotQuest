<?php

namespace RiotQuest\Docs;

use Jenssegers\Blade\Blade;

class Generator
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
            $ref = new \ReflectionClass("\\RiotQuest\\Components\\Framework\\Collections\\" . $file);

            $this->vars[] = $ref;
            $class = new \stdClass();
            $class->name = $file;
            $class->spaced = preg_replace_callback('/([A-Z])/m', function ($matches) {
                return " $matches[0]";
            }, $file);
            $class->dashed = trim(preg_replace_callback('/([A-Z])/m', function ($matches) {
                return "-$matches[0]";
            }, $file), '-');
            $class->props = [];
            preg_match_all('/(@property ([\w\[\]]+) \$([\w]+))/m', $ref->getDocComment(), $matches);
            foreach ($matches[3] as $key => $value) {
                $class->props[$value] = $matches[2][$key];
            }

            $render = $this->blade->make('collection', ['class' => $class]);
            file_put_contents($this->out . '/' . $class->dashed . '.md', $render);
        }
    }

}
