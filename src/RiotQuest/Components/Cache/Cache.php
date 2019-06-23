<?php

namespace RiotQuest\Components\Cache;

use League\Flysystem\Adapter\Local;
use League\Flysystem\FileExistsException;
use League\Flysystem\FileNotFoundException;
use League\Flysystem\Filesystem;
use RiotQuest\Contracts\LeagueException;

/**
 * Class Cache
 * @package RiotQuest\Components\Framework\Cache
 */
class Cache
{

    /**
     * @var string
     */
    protected $namespace = '';

    /**
     * @var Filesystem
     */
    private $fs;

    /**
     * Cache constructor.
     */
    public function __construct()
    {
        $this->fs = new Filesystem(new Local(__DIR__ . "/../../../storage/cache/$this->namespace"));
    }

    /**
     * @param $key
     * @param $value
     * @param null $ttl
     * @throws FileExistsException
     * @throws FileNotFoundException
     */
    public function set($key, $value, $ttl = null): void
    {
        if (is_string($ttl)) $ttl = explode(',', $ttl)[0];

        $this->write($key, json_encode([
            'data' => (string)$value,
            'ttl' => ($ttl === null) ? null : (float)(time() + $ttl)
        ]));
    }

    /**
     * @param $key
     * @param null $default
     * @return mixed|null
     * @throws FileNotFoundException
     * @throws LeagueException
     */
    public function get($key, $default = null)
    {
        return $this->exists($key) ? ($this->read($key)['data']) : $default;
    }

    /**
     * @param $keys
     * @param null $default
     * @return array
     */
    public function getMultiple($keys, $default = null)
    {
        return array_map(function ($e) use ($default) {
            return $this->get($e, $default);
        }, (array)$keys);
    }

    /**
     * @param $values
     * @param null $ttl
     * @throws FileExistsException
     * @throws FileNotFoundException
     */
    public function setMultiple($values, $ttl = null): void
    {
        foreach ($values as $key => $value) {
            $this->set($key, $value, $ttl);
        }
    }

    /**
     * @param $key
     * @return bool
     * @throws FileNotFoundException
     * @throws LeagueException
     */
    public function has($key): bool
    {
        if ($this->exists($key)) {
            $ttl = $this->read($key);
            if ($ttl === null) {
                return false;
            }

            return $ttl['ttl'] === null ? true : $ttl['ttl'] > time();
        }

        return false;
    }

    /**
     * @param $real
     * @return array
     * @throws LeagueException
     * @throws FileNotFoundException
     */
    private function read($real): array
    {
        $key = $this->hash($real);

        if ($this->exists($real)) {
            return json_decode($this->fs->read($key), 1);
        }

        throw new LeagueException("ERROR (code 9): Target file not found.");
    }

    /**
     * @param $real
     * @param $content
     * @throws FileExistsException
     * @throws FileNotFoundException
     */
    private function write($real, $content): void
    {
        $key = $this->hash($real);

        if ($this->exists($real)) {
            $this->fs->update($key, $content);
        } else {
            $this->fs->write($key, $content);
        }
    }

    /**
     * @param $real
     * @return bool
     */
    private function exists($real): bool
    {
        $key = $this->hash($real);

        return $this->fs->has($key);
    }

    /**
     * Note: These strings do not have to be cryptographically secure.
     *
     * @param $sub
     * @return string
     */
    private function hash($sub): string
    {
        return md5($sub);
    }


}
