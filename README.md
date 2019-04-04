# RiotQuest

RiotQuest is a modern PHP 7+ framework for the League of Legends API

The framework aims at giving you a simple way to interact with the API.

Here's a list of some of RiotQuest's features.

- [Automatic Rate Limiting](//github.com/supergrecko/RiotQuest/wiki/Rate-Limiting): The rate limiter component prevents you from passing the rate limits - no blacklists or 429's! And of course it's automatic!
- [Automatic Caching](//github.com/supergrecko/RiotQuest/wiki/Caching): The framework caches every successful request - automatically!
- [Custom Collections](//github.com/supergrecko/RiotQuest/wiki/Return-Types): Every request returns an object which makes data management significantly easier!
- [Environment](//github.com/supergrecko/RiotQuest/wiki/Environment): Load API keys using the environment!
- [Command Line Interface](//github.com/supergrecko/RiotQuest/wiki/Command-Line): Use the API within the command line as well as managing caches!
- Standardized with PSR-1, PSR-2, PSR-4 & PSR-16


The entire project is licensed under the MIT License.

# Getting Started

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

## Usage

To get you started, we've created a 3-step guide to working with the framework. 

This guide should get you up and working.

- [Creating the Client](//github.com/supergrecko/RiotQuest/wiki/Creating-the-Client)
- [Sending the Request](//github.com/supergrecko/RiotQuest/wiki/Sending-the-Request)
- [Handling the Response](//github.com/supergrecko/RiotQuest/wiki/Handling-the-Response)

# Example

Make a request to Summoner V4 on NA with Summoner Name "RiotSchmick"

```php
<?php

require __DIR__ . '/vendor/autoload.php';

use RiotQuest\Client;

$summoner = Client::summoner('na1')->name('RiotSchmick');
?>
```

# Endpoints

RiotQuest currently supports every endpoint except Tournament related ones.
