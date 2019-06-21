<?php

namespace RiotQuest\ServiceProviders;

use Illuminate\Support\ServiceProvider;
use RiotQuest\Client;
use RiotQuest\Contracts\LeagueException;

/**
 * Class LeagueServiceProvider
 *
 * @package RiotQuest\ServiceProviders
 */
class LeagueServiceProvider extends ServiceProvider
{

    /**
     * @throws LeagueException
     */
    public function boot(): void
    {
        Client::boot();
    }

}
