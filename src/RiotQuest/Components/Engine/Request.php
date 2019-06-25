<?php

namespace RiotQuest\Components\Engine;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use League\Flysystem\FileExistsException;
use League\Flysystem\FileNotFoundException;
use Psr\SimpleCache\InvalidArgumentException;
use RiotQuest\Components\Client\Application;
use RiotQuest\Components\Client\Token;
use RiotQuest\Contracts\LeagueException;

/**
 * Class RequestCache
 *
 * Definition to send HTTP request to the
 * Riot Games API
 *
 * Uses a sort-of query builder to make a nice
 * method-chaining API to build requests
 *
 * @package RiotQuest\Components\Http
 */
class Request
{

    /**
     *
     */
    private const FROM_CACHE = 1;
    /**
     *
     */
    private const FROM_API = 0;

    /**
     * @var Collection
     */
    private $variables;

    /**
     * Request constructor.
     */
    public function __construct()
    {
        // Default values
        $this->variables = new Collection([
            'key' => 'STANDARD',
            'body' => null,
            'ttl' => 3600,
            'method' => 'GET',
            'arguments' => [],
            'destination' => 'https://{?}.api.riotgames.com/',
            'function' => null,
            'region' => 'euw1'
        ]);
    }

    /**
     * @return Request
     */
    public static function create(): Request
    {
        return new Request();
    }

    /**
     * @param string $key
     * @param $value
     * @return Request
     */
    public function with(string $key, $value): self
    {
        $this->variables->put($key, $value);

        return $this;
    }

    /**
     * @param string $key
     * @return mixed
     */
    private function get(string $key)
    {
        return $this->variables->get($key);
    }

    /**
     * @return mixed|null
     * @throws LeagueException
     */
    public function send()
    {
        try {
            $type = $this->validate();

            Application::log('INFO', 'Accessing {endpoint} at {url}', ['endpoint' => $this->get('function'), 'url' => $this->get('destination')]);

            switch ($type) {
                case self::FROM_API:
                    return $this->fromAPI();
                case self::FROM_CACHE:
                    return $this->fromCache();
            }

            throw new LeagueException("ERROR (code 1): Internal Service Error. Please report this error by opening an issue on GitHub.");
        } catch (GuzzleException $ex) {
            throw new LeagueException("ERROR (code 2): Internal Service Error. Please report this error by opening an issue on GitHub.");
        } catch (InvalidArgumentException $ex) {
            throw new LeagueException("ERROR (code 3): Internal Service Error. Please report this error by opening an issue on GitHub.");
        } catch (FileExistsException $ex) {
            throw new LeagueException("ERROR (code 4): Cache Directory is set up incorrectly. Attempt to reinstall RiotQuest.");
        } catch (FileNotFoundException $ex) {
            throw new LeagueException("ERROR (code 5): Cache Directory is not set up. Attempt to reinstall RiotQuest.");
        }
    }

    /**
     * @return int
     * @throws FileNotFoundException
     * @throws LeagueException
     */
    private function validate(): int
    {
        if (!($new = (Utils::resolveRegion($this->get('region'))))) {
            throw new LeagueException('ERROR (code 6): Specified region could not be resolved.');
        }

        $this->variables->put('region', $new);

        $this->variables->put('destination', Str::replaceFirst(
            '{region}',
            $this->get('region'),
            $this->get('destination')
        ));

        $this->variables->put('destination', Str::replaceArray(
            '{?}',
            $this->get('arguments'),
            $this->get('destination')
        ));

        $cache = Application::getInstance()->getCache('request');

        if ($cache->has($this->get('destination')) && $this->get('ttl') !== false) {
            return self::FROM_CACHE;
        } else {
            return self::FROM_API;
        }
    }

    /**
     * @return mixed|null
     * @throws FileNotFoundException
     * @throws LeagueException
     */
    private function fromCache()
    {
        $cache = Application::getInstance()->getCache('request');
        $collection = Utils::$responses[$this->get('function')];

        $items = json_decode($cache->get($this->get('destination')), 1);

        return $this->respond($collection, $items);
    }

    /**
     * @return mixed|null
     * @throws FileExistsException
     * @throws FileNotFoundException
     * @throws GuzzleException
     * @throws InvalidArgumentException
     * @throws LeagueException
     */
    private function fromAPI()
    {
        $region = $this->get('region');
        $function = $this->get('function');
        $key = $this->get('key');

        if (Application::getInstance()->hittable($region, $function, $key)) {
            /** @var Token $token */
            $token = Application::getInstance()->getKeys()[$this->get('key')];

            $res = (new Client())->request(
                $this->get('method'),
                $this->get('destination'),
                [
                    'body' => json_encode($this->get('body')),
                    'headers' => [
                        'Content-Type' => 'application/json',
                        'X-Riot-Token' => $token->getKey()
                    ],
                    'http_errors' => false
                ]
            );

            $limits = explode(':', $res->getHeader('X-Method-Rate-Limit')[0]);

            // Note: Application::register registers both endpoint and global limit
            Application::getInstance()->register($region, $function, $key, $limits);

            $items = (array)json_decode($res->getBody()->getContents(), 1);

            if ($res->getStatusCode() >= 300 && !in_array($function, Application::$rules['HTTP_ERROR_EXCEPT'])) {
                throw new LeagueException("ERROR (code 7): API Error. Status Code: " . $res->getStatusCode(), 0, null, $items);
            }

            Application::log('INFO', 'Sent HTTP request to API at {url}.', [
                'url' => $this->get('destination'),
            ]);

            if (!in_array($function, Application::$rules['CACHE_NONE'])) {
                $cache = Application::getInstance()->getCache('request');

                if (in_array($function, Application::$rules['CACHE_PERMANENT'])) {
                    $cache->set($this->get('destination'), json_encode($items));
                } else {
                    $cache->set($this->get('destination'), json_encode($items), $this->get('ttl'));
                }
            }

            $collection = Utils::$responses[$function];

            return $this->respond($collection, $items);
        }

        throw new LeagueException('ERROR (code 8): Rate Limit would be exceeded by making this call.');
    }

    /**
     * @param $collection
     * @param $items
     * @return mixed|null
     */
    private function respond($collection, $items)
    {
        if ($collection !== false) {
            $template = Utils::loadTemplate($collection);
            return Utils::traverse($items, $template, $this->get('region'));
        }

        return $collection ? $items : ($items[0] ?? null);
    }

}
