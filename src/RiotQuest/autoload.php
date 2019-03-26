<?php

use Symfony\Component\Dotenv\Dotenv;

use RiotQuest\Client;
use RiotQuest\Contracts\RiotQuestException;

// Loads environment variables into app and inits the client.
if (file_exists(__DIR__ . '/../../.env')) {

    (new Dotenv())->load(__DIR__ . '/../../.env');

    if (getenv('RIOTQUEST_LOAD_ENV')) {
        $keys = [];
        $provider = getenv('RIOTQUEST_CACHE');
        if (getenv('RIOTQUEST_STANDARD_KEY')) {
            $keys[] = Client::token(getenv('RIOTQUEST_STANDARD_KEY'), 'STANDARD', getenv('RIOTQUEST_STANDARD_LIMIT'));
        }
        if (getenv('RIOTQUEST_TOURNAMENT_KEY')) {
            $keys[] = Client::token(getenv('RIOTQUEST_TOURNAMENT_KEY'), 'TOURNAMENT', getenv('RIOTQUEST_TOURNAMENT_LIMIT'));
        }
        if (count($keys)) {
            Client::initialize(
                new $provider(),
                ...$keys
            );
        } else {
            throw new RiotQuestException("Environment loading is enabled, but no keys were found.");
        }
    }

}
