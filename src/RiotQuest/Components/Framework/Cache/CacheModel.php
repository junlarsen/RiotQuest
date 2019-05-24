<?php

namespace RiotQuest\Components\Framework\Cache;

use League\Flysystem\Adapter\Local;
use League\Flysystem\Filesystem;
use Psr\SimpleCache\CacheInterface;

class CacheModel implements CacheInterface {

    /**
     * @var string 
     */
    protected $namespace = '';

    /**
     * @var Filesystem
     */
    private $fs;

    /**
     * CacheModel constructor.
     */
    public function __construct()
    {
        $this->fs = new Filesystem(new Local(__DIR__ . "/../../../../storage/cache/$this->namespace"));
    }

    /**
     * @param string $key
     * @param mixed $value
     * @param null $ttl
     * @return bool|void
     */
    public function set($key, $value, $ttl = null)
    {
        if (is_string($ttl)) $ttl = explode(',', $ttl)[0];

        $this->write($key, json_encode([
            'data' => (string) $value,
            'ttl' => ($ttl === null) ? null : (float) (time() + $ttl)
        ]));
    }

    /**
     * @param string $key
     * @param null $default
     * @return mixed|null
     */
    public function get($key, $default = null)
    {
        return $this->exists($key) ? ($this->read($key)['data']) : $default;
    }

    public function delete($key)
    {
        // TODO: Implement delete() method.
    }

    public function clear()
    {
        // TODO: Implement clear() method.
    }

    public function getMultiple($keys, $default = null)
    {
        return array_map(function ($e) use ($default) {
            return $this->get($e, $default);
        }, (array) $keys);
    }

    public function setMultiple($values, $ttl = null)
    {
        foreach ($values as $key => $value) {
            $this->set($key, $value, $ttl);
        }
    }

    public function deleteMultiple($keys)
    {
        // TODO: Implement deleteMultiple() method.
    }

    /**
     * @param string $key
     * @return bool
     */
    public function has($key)
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
     * @return mixed|null
     * @throws \League\Flysystem\FileNotFoundException
     */
    private function read($real) {
        $key = $this->hash($real);

        if ($this->exists($real)) {
            $a = json_decode($this->fs->read($key), 1);
            return $a;
        }

        return null;
    }

    /**
     * @param $real
     * @param $content
     * @throws \League\Flysystem\FileExistsException
     * @throws \League\Flysystem\FileNotFoundException
     */
    private function write($real, $content) {
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
    private function exists($real) {
        $key = $this->hash($real);

        return $this->fs->has($key);
    }

    /**
     * @param $sub
     * @return string
     */
    private function hash($sub) {
        return md5($sub);
    }


}