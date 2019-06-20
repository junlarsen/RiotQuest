<?php

namespace RiotQuest\ServiceProviders;

use Illuminate\Support\ServiceProvider;
use RiotQuest\Client;

class LeagueServiceProvider extends ServiceProvider {

    public function boot(): void {
        Client::boot();
    }

}
