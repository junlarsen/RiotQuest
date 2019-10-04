<?php

use RiotQuest\Codegen\Result;

$g = new RiotQuest\Codegen\Codegen();
$g->createAll(function (Result $r) {
    $r->pipe(__DIR__ . "\\..\\src\storage\\templates\\" . $r->toArray()['name'] . ".json");
});