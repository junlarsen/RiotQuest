<?php

namespace RiotQuest\Codegen;

use Closure;
use League\Flysystem\Filesystem;
use League\Flysystem\Adapter\Local;
use Illuminate\Support\Collection;
use ReflectionException;
use RiotQuest\Components\Collections\Collection as LeagueCollection;
use ReflectionClass;
use ReflectionMethod;

/**
 * Class Codegen
 * 
 * @package RiotQuest\Codegen
 */
class Codegen
{

    /**
     * @var Codegen
     */
    private static $instance;

    /**
     * @return Codegen
     */
    public static function getInstance(): Codegen {
        static::$instance = static::$instance ?? new Codegen();

        return static::$instance;
    }

    /**
     * @param Closure $closure
     * @throws ReflectionException
     */
    public static function createAll(Closure $closure): void {
        $codegen = static::getInstance();

        $in = new Filesystem(new Local(__DIR__ . '/../Components/Collections/'));

        foreach ($in->listContents() as $file) {
            if ($file['type'] === 'file') {
                $res = $codegen->createFromClass("\\RiotQuest\\Components\\Collections\\" . $file['filename']);
                
                $closure->call($res, $res);
            }
        }
    }

    /**
     * @param string $namespace
     * @return Result
     * @throws ReflectionException
     */
    public function createFromClass(string $namespace): Result {
        $template = new Collection();
        $reflector = new ReflectionClass($namespace);

        $doc = $reflector->getDocComment();
        $tags = $this->getDocTags($doc);
        $fns = new Collection($reflector->getMethods());

        $template->put('props', $this->parsePropertyTags($tags))
            ->put('sees', $this->parseSeeTags($tags))
            ->put('list', $this->parseListTags($tags))
            ->put('methods', $this->parseFunctions($fns))
            ->put('name', $reflector->getShortName())
            ->put('class', $reflector->getName());
        
        return new Result($template);
    }

    /**
     * @param string $comment
     * @return Collection
     */
    private function getDocTags(string $comment): Collection {
        $comment = explode("\r\n", $comment);

        $lines = new Collection();
        foreach ($comment as $line) {
            $line = trim($line);
            $line = substr($line, 2);

            if (substr($line, 0, 1) === '@') {
                $lines->add(explode(' ', $line));
            }
        }

        return new Collection($lines);
    }

    /**
     * @param Collection $tags
     * @return Collection
     */
    private function parsePropertyTags(Collection $tags): Collection {
        $res = new Collection();

        $tags->each(function ($el) use ($res) {
            if ($el[0] === '@property') {
                $res->put($el[2], $el[1]);
            }
        });

        return $res;
    }

    /**
     * @param Collection $tags
     * @return Collection
     */
    private function parseSeeTags(Collection $tags): Collection {
        $res = new Collection();

        $tags->each(function ($el) use ($res) {
            if ($el[0] === '@see') {
                $res->push($el[1]);
            }
        });

        return $res;
    }

    /**
     * @param Collection $tags
     * @return Collection
     */
    private function parseListTags(Collection $tags): Collection {
        $res = new Collection();

        $tags->each(function ($el) use ($res) {
            if ($el[0] === '@list') {
                $res->push($el[1]);
            }
        });

        return $res;
    }

    /**
     * @param Collection $tags
     * @return Collection
     */
    private function parseParamTags(Collection $tags): Collection {
        $res = new Collection();

        $tags->each(function ($el) use ($res) {
            if ($el[0] === '@param') {
                $res->put($el[2], $el[1]);
            }
        });

        return $res;
    }

    /**
     * @param Collection $tags
     * @return Collection
     */
    private function parseReturnTags(Collection $tags): Collection {
        $res = new Collection();

        $tags->each(function ($el) use ($res) {
            if ($el[0] === '@return') {
                $res->push($el[1]);
            }
        });

        return $res;
    }

    /**
     * @param Collection $functions
     * @return Collection
     */
    private function parseFunctions(Collection $functions): Collection {
        $res = new Collection();

        $functions->each(function (ReflectionMethod $fn) use ($res) {
            if (!in_array($fn->getDeclaringClass()->getName(), [Collection::class, LeagueCollection::class])) {
                $signature = $this->getFunctionSignature($fn);

                $res->put($signature->get('name'), $signature);
            }
        });

        return $res;
    }

    /**
     * @param ReflectionMethod $method
     * @return Collection
     */
    private function getFunctionSignature(ReflectionMethod $method): Collection {
        $res = new Collection();

        $doc = $method->getDocComment();
        $tags = $this->getDocTags($doc);

        $res->put('name', $method->getShortName())
            ->put('returns', $this->parseReturnTags($tags))
            ->put('params', $this->parseParamTags($tags));
        
        return $res;
    }

}
