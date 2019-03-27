<?php

use Symfony\Component\Dotenv\Dotenv;

use RiotQuest\Client;
use RiotQuest\Contracts\RiotQuestException;

if (!defined('RIOTQUEST_ENV')) {
    define('RIOTQUEST_ENV', 'API');
}

// Loads environment variables into app and inits the client.
if (file_exists(__DIR__ . '/../../.env')) {
    (new Dotenv())->load(__DIR__ . '/../../.env');
    if (getenv('RIOTQUEST_LOAD_ENV')) {
        $keys = [];
        if (getenv('RIOTQUEST_STANDARD_KEY')) {
            $keys[] = Client::token(getenv('RIOTQUEST_STANDARD_KEY'), 'STANDARD', getenv('RIOTQUEST_STANDARD_LIMIT'));
        }
        if (getenv('RIOTQUEST_TOURNAMENT_KEY')) {
            $keys[] = Client::token(getenv('RIOTQUEST_TOURNAMENT_KEY'), 'TOURNAMENT', getenv('RIOTQUEST_TOURNAMENT_LIMIT'));
        }
        if (count($keys)) {
            $prov = getenv('RIOTQUEST_CACHE');
            Client::initialize(
                new $prov(),
                ...$keys
            );
            define('RIOTQUEST_ENVLOAD', 1);
        } else {
            throw new RiotQuestException("Environment loading is enabled, but no keys were found.");
        }
    } else {
        define('RIOTQUEST_ENVLOAD', 0);
        throw new RiotQuestException("Environment loading is enabled, but no valid CacheProvider or keys were found");
    }

}
