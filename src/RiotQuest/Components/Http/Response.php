<?php

namespace RiotQuest\Components\Http;

class Response
{

    private $request;

    private $response;

    public function __construct(Request $request, $response)
    {
        $this->request = $request;
        $this->response = $response;
    }

}
