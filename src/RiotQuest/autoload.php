<?php

use Symfony\Component\Dotenv\Dotenv;
use RiotQuest\Components\DataProvider\DataDragon\Assets;
use RiotQuest\Components\DataProvider\DataDragon\Dragon;
use RiotQuest\Components\Framework\Engine\Filesystem;
use RiotQuest\Client;

if (!defined('RIOTQUEST_ENV')) define('RIOTQUEST_ENV', 'API');

if (file_exists(__DIR__ . '/../../.env')) (new Dotenv())->load(__DIR__ . '/../../.env');

if (!file_exists(__DIR__ . '/../storage/templates/manifest.json')) (new Filesystem())->generateTemplates();

if (getenv('RIOTQUEST_LOAD_ENV' || $_ENV['RIOTQUEST_LOAD_ENV'])) {
    Client::loadFromEnvironment();
    define('RIOTQUEST_ENVLOAD', 1);
} else {
    define('RIOTQUEST_ENVLOAD', 0);
}

Dragon::enable();
Assets::enable();
