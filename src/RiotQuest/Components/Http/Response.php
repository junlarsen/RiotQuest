<?php

namespace RiotQuest\Components\Http;

use RiotQuest\Components\Framework\Library;
use RiotQuest\Support\Helpers\League;
use RiotQuest\Components\Riot\Client\Client;

class Response
{

    private $request;

    public $response;

    public function __construct(Request $request, $response)
    {
        $this->request = $request;
        $this->response = $response;
    }

    public function collect()
    {
        $limits = $this->response->getHeaders()['X-Method-Rate-Limit'][0];
        Client::hit(
            $this->request->arguments['region'],
            $this->request->parent[0] . '.' . $this->request->parent[1],
            [
                'interval' => explode(':', $limits)[1],
                'count' => explode(':', $limits)[0]
            ]);
        $load = json_decode($this->response->getBody()->getContents(), 1);
        $ref = League::$returnTypes[$this->request->parent[0]][$this->request->parent[1]];
        return Library::traverse($load, Library::template($ref));
    }

}
