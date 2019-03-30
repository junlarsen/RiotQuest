<?php

use Symfony\Component\Dotenv\Dotenv;
use RiotQuest\Components\DataProvider\DataDragon\Assets;
use RiotQuest\Components\DataProvider\DataDragon\Dragon;
use RiotQuest\Components\Framework\Engine\Filesystem;
use RiotQuest\Client;
use RiotQuest\Contracts\RiotQuestException;

if (!defined('RIOTQUEST_ENV')) {
    define('RIOTQUEST_ENV', 'API');
}
// Loads environment variables into app and initiates the client.
if (file_exists(__DIR__ . '/../../.env')) {
    (new Dotenv())->load(__DIR__ . '/../../.env');
    if (getenv('RIOTQUEST_LOAD_ENV')) {
        $keys = [];
        foreach (['STANDARD', 'TOURNAMENT'] as $k) {
            if (getenv("RIOTQUEST_{$k}_KEY")) $keys[] = Client::token(getenv("RIOTQUEST_{$k}_KEY"), $k, getenv("RIOTQUEST_{$k}_LIMIT"));
        }
        $cache = getenv('RIOTQUEST_CACHE');
        if (count($keys)) {
            Client::initialize(new $cache, ...$keys);
            define('RIOTQUEST_ENVLOAD', 1);
        } else throw new RiotQuestException("Environment loading is enabled, but no keys were found.");
    } else {
        define('RIOTQUEST_ENVLOAD', 0);
        throw new RiotQuestException("Environment loading is enabled, but no valid CacheProvider or keys were found");
    }
}

Dragon::enable();
Assets::enable();
