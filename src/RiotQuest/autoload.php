<?php

if (!defined('RIOTQUEST_ENV')) define('RIOTQUEST_ENV', 'API');

if (!file_exists(__DIR__ . '/../storage/templates/manifest.json')) {
    (new \RiotQuest\Components\Framework\Engine\Filesystem())->generateTemplates();
}
