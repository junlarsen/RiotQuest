<?php

namespace RiotQuest\Codegen;

use RiotQuest\Components\Collections\Collection;
use Jenssegers\Blade\Blade;

/**
 * Class DocumentGenerator
 * @package RiotQuest\Codegen
 */
class DocumentGenerator {

    /**
     *
     */
    public function createAll(): void {
        $load = json_decode(file_get_contents(__DIR__ . '/assets/manifest.json'), 1);

        foreach ($load as $item) {
            $this->create($item);
        }
    }

    /**
     * @param array $collection
     */
    private function create(array $collection): void {
        $collection = (new Collection($collection))->recursive();

        $blade = new Blade(__DIR__ . '/assets', __DIR__ . '/cache');

        file_put_contents(__DIR__ . '/out/' . $collection->get('name'), $blade->make('layout', ['page' => $collection]));
    }

}
