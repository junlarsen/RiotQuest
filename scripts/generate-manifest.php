<?php

use Illuminate\Support\Collection;
use RiotQuest\Codegen\Result;

$m = new Collection();

$g = new RiotQuest\Codegen\Codegen();
$g->createAll(function (Result $r) use ($m) {
    $m->put($r->toArray()['name'], $r->toArray());
});

file_put_contents(__DIR__ . "/../src/RiotQuest/Codegen/assets/manifest.json", $m->toArray());