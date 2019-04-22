<?php

namespace RiotQuest\Components\Framework\Cache;

use Psr\SimpleCache\CacheInterface;

/**
 * Class CacheModel
 *
 * PSR-16 compliant simple cache provider
 *
 * @package RiotQuest\Components\Framework\Cache
 */
class CacheModel implements CacheInterface
{

    /**
     * Base path to CacheModel directory
     *
     * @var string
     */
    protected $path = __DIR__ . '/../../../../storage/cache/';

    /**
     * @var string
     */
    protected $namespace = '';

    /**
     * CacheModel constructor.
     */
    public function __construct()
    {
        $this->path .= $this->namespace;
        @mkdir($this->path);
    }

    /**
     * Get single key
     *
     * @param string $key
     * @param null $default
     * @return false|mixed|string|null
     */
    public function get($key, $default = null)
    {
        return $this->has($key) ? json_decode(file_get_contents($this->path . $this->key($key)), 1)['data'] : $default;
    }

    /**
     * Get multiple keys
     *
     * @param iterable $keys
     * @param null $default
     * @return array|iterable
     */
    public function getMultiple($keys, $default = null)
    {
        return array_map(function ($e) use ($default) {
            return $this->get($e, $default);
        }, (array) $keys);
    }

    /**
     * Set a key and value
     *
     * @param string $key
     * @param mixed $value
     * @param null $ttl
     * @return bool|void
     */
    public function set($key, $value, $ttl = null)
    {
        if (is_string($ttl)) $ttl = explode(',', $ttl)[0];
        $key = $this->key($key);
        @mkdir($this->path . $key, 755, true);
        file_put_contents($this->path . $key, json_encode([
            'data' => (string) $value,
            'ttl' => $ttl === null ? null : (float) time() + $ttl
        ]));
    }

    /**
     * Set multiple keys
     *
     * @param iterable $values
     * @param null $ttl
     * @return bool|void
     */
    public function setMultiple($values, $ttl = null)
    {
        foreach ($values as $key => $value) {
            $this->set($key, $value, $ttl);
        }
    }

    /**
     * Deletes a single key
     *
     * @param string $key
     * @return bool|void
     */
    public function delete($key)
    {
        $key = $this->key($key);
        @unlink($this->path . $key);
    }

    /**
     * Deletes a set of keys
     *
     * @param iterable $keys
     * @return bool|void
     * @throws \Psr\SimpleCache\InvalidArgumentException
     */
    public function deleteMultiple($keys)
    {
        foreach ($keys as $key) {
            $this->delete($key);
        }
    }

    /**
     * Confirm whether the cache has this key or not
     *
     * @param string $key
     * @return bool
     */
    public function has($key)
    {
        $key = $this->key($key);
        if (file_exists($this->path . $key)) {
            $ttl = json_decode(file_get_contents($this->path . $key), 1)['ttl'];
            return $ttl === null ? true : $ttl > time();
        }
        return false;
    }

    /**
     * Empties the entire cache
     *
     * @return bool|void
     */
    public function clear()
    {
        $this->remove($this->path);
    }

    /**
     * Hashes the cache key
     *
     * @param $key
     * @return string
     */
    public function key($key)
    {
        return md5($key);
    }

    /**
     * Recursively wipes a directory
     *
     * @param $path
     */
    private function remove($path)
    {
        $files = array_diff(scandir($path), ['..', '.']);
        foreach ($files as $file) {
            if (is_dir("$path/$file")) {
                $this->remove($path . $file);
                rmdir("$path/$file");
            } else {
                unlink($path . $file);
            }
        }
    }

}
