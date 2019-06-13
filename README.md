# RiotQuest &mdash; API Framework

RiotQuest is a modern PHP 7+ framework for the League of Legends API

The framework aims at giving you a simple and elegant way to interact with the API.

Here's a list of some of RiotQuest's features.

- Automatic Rate Limiting
- Automatic Caching
- Laravel Collections over primitive Arrays
- Environment Variables Support
- Laravel Integrations
- DataDragon downloader
- Automatically updating DataDragon copies
- Localization available for DataDragon
- Laravel-like Syntax


The entire project is licensed under the MIT License.

# Getting Started

## Example

Make a request to Summoner V4 on EUW with Summoner Name "supergrecko"

```php
<?php
use RiotQuest\Client;

$summoner = Client::summoner('euw')->name('supergrecko');
?>
```

## Documentation

The documentation for RiotQuest can be located at https://riotquest.supergrecko.dev/


## Prerequisites

The library uses Composer for class autoloading and dependency management. Here is a list of things you'll need to get started with RiotQuest.

- PHP 7.0+
- ext-json
- ext-curl
- Composer

## Installation

To install RiotQuest, simply install it using Composer.

```bash
$ composer require supergrecko/riot-quest
```