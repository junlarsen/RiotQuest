<?php

namespace RiotQuest\Codegen;

use Illuminate\Support\Collection;

/**
 * Class Result
 * 
 * @package RiotQuest\Codegen
 */
class Result {

    /**
     * @var Collection
     */
    private $result;

    /**
     * Result constructor.
     * @param Collection $collection
     */
    public function __construct(Collection $collection)
    {
        $this->result = $collection;
    }

    /**
     * @return array
     */
    public function toArray(): array {
        return $this->result->toArray();
    }

    /**
     * @param string $path
     * @return Result
     */
    public function pipe(string $path): self {
        file_put_contents($path, $this->toString());

        return $this;
    }

    /**
     * @return string
     */
    public function toString(): string {
        return $this->result->toJson();
    }

}
