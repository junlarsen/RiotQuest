<?php

namespace RiotQuest\Components\Engine;

use GuzzleHttp\Client;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Psr\Cache\InvalidArgumentException;
use RiotQuest\Components\Client\Application;
use RiotQuest\Contracts\LeagueException;
use Symfony\Contracts\Cache\ItemInterface;
use Exception;

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
     * @param string $key
     * @return string
     */
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
     * @throws InvalidArgumentException
     * @throws LeagueException
     */
    public function send()
    {
        try {
            Application::log('INFO', 'Accessing {endpoint} at {url}', ['endpoint' => $this->get('function'), 'url' => $this->get('destination')]);

            $this->validate();

            if (Application::getInstance()->hittable(
                $this->get('region'),
                $this->get('function'),
                $this->get('key')
            )) {
                return $this->finalize();
            }
            throw new LeagueException(("ERROR (code 8): Rate Limit would of been reached by sending this request."));
        } catch (LeagueException $ex) {
            throw $ex;
        } catch (Exception $ex) {
            echo $ex->getTraceAsString();
            throw new LeagueException("ERROR (code 3): Internal Service Error. Please report this error by opening an issue on GitHub.");
        }
    }

    /**
     * @return $this
     * @throws LeagueException
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

        return $this;
    }

    /**
     * @return mixed|null
     * @throws InvalidArgumentException
     */
    private function finalize() {
        $collection = Utils::$responses[$this->get('function')];
        $key = md5("riotquest.requests." . static::encode($this->get('destination')));
        $items = Application::getInstance()->getCache()->get($key, function (ItemInterface $item) {
            $function = $this->get('function');

            if (!in_array($function, Application::$rules['CACHE_NONE'])) {
                if (in_array($function, Application::$rules['CACHE_PERMANENT'])) {
                    $item->expiresAfter(86400 * 360 * 3); // 3 years
                } else {
                    $time = $this->get('ttl') ?: 0;
                    $item->expiresAfter($time);
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

            $rl = Application::getInstance()->getManager();

            // Some endpoints don't have method limit
            if ($method = $res->getHeader('X-Method-Rate-Limit')) {
                $method = explode(':', $method[0]);
                if (isset($method[2])) {
                    $method = [$method[0], explode(',', $method[1])[0]];
                }

                $rl->register(
                    $this->get('region'),
                    $this->get('function'),
                    $this->get('key'),
                    $method
                );
            }

            // Some endpoints don't have app limit
            if ($app = $res->getHeader('X-App-Rate-Limit')) {
                $app = explode(':', $app[0]);

                if (isset($app[2])) {
                    $app = [$app[0], explode(',', $app[1])[0]];
                }

                $rl->register(
                    $this->get('region'),
                    'default',
                    $this->get('key'),
                    $app
                );
            }

            $body = (array)json_decode($res->getBody()->getContents(), 1);

            // If res is not in whitelist and the code was not a 200 code
            if ($res->getStatusCode() >= 300 && !in_array($function, Application::$rules['HTTP_ERROR_EXCEPT'])) {
                throw new LeagueException("ERROR (code 7): API Error. Status Code: " . $res->getStatusCode(), 0, null, $body);
            }

            Application::log('INFO', 'Sent HTTP request to API at {url}.', [
                'url' => $this->get('destination'),
            ]);

            return $body;
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
