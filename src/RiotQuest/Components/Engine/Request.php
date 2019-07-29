<?php

namespace RiotQuest\Components\Engine;

use GuzzleHttp\Client;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Psr\Cache\InvalidArgumentException;
use RiotQuest\Components\Client\Application;
use RiotQuest\Contracts\LeagueException;
use Symfony\Contracts\Cache\ItemInterface;

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

    private static function encode(string $key): string {
        return base64_encode($key);
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
            Application::log('INFO', 'Accessing {endpoint} at {url}', ['endpoint' => $this->get('function'), 'url' => $this->get('destination')]);

            return $this->validate();
        } catch (InvalidArgumentException $ex) {
            throw new LeagueException("ERROR (code 3): Internal Service Error. Please report this error by opening an issue on GitHub.");
        }
    }

    /**
     * @return mixed
     * @throws LeagueException
     * @throws \Psr\Cache\InvalidArgumentException
     */
    private function validate()
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

        return $this->finalize();
    }

    /**
     * @return mixed|null
     * @throws \Psr\Cache\InvalidArgumentException
     */
    private function finalize() {
        $collection = Utils::$responses[$this->get('function')];
        $items = Application::getInstance()->getCache()->get("riotquest.requests." . static::encode($this->get('destination')), function (ItemInterface $item) {
            $function = $this->get('function');

            if (!in_array($function, Application::$rules['CACHE_NONE'])) {
                if (in_array($function, Application::$rules['CACHE_PERMANENT'])) {
                    $item->expiresAfter(86400 * 360 * 3); // 3 years
                } else {
                    $item->expiresAfter($this->get('ttl'));
                }
            } else {
                $item->expiresAfter(0);
            }

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

            $body = (array)json_decode($res->getBody()->getContents(), 1);
            if ($res->getStatusCode() >= 300 && !in_array($function, Application::$rules['HTTP_ERROR_EXCEPT'])) {
                throw new LeagueException("ERROR (code 7): API Error. Status Code: " . $res->getStatusCode(), 0, null, $body);
            }
            Application::log('INFO', 'Sent HTTP request to API at {url}.', [
                'url' => $this->get('destination'),
            ]);

            return $body;
            #throw new LeagueException('ERROR (code 8): Rate Limit would be exceeded by making this call.');
        });

        return $this->respond($collection, $items);
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
