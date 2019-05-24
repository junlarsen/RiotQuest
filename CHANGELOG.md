# v1.2.0

Adds the new LeagueEntries endpoint and removes one environment variable

- \+ Adds new LeagueEntries endpoint
- \- RIOTQUEST_LOAD_ENV variable removed because you're forced to use the env.

# v1.1.0

Removes the CLI and adds cache bypassing

- \+ Bypassing the cache timer (forces request to APIs)
- \- Removes the CLI due to bugs

# v1.0.3

Patches up final issues with 1.0.2 cache bug

- \+ Complete cache model fix

# v1.0.2

Fixes deprecated CLI where commands would not be loaded.

- \+ Patch for Laravel environments
- \+ Minor Cache fix where directories would not be found 

# v1.0.1

Fixes an error with Composer loading library before environment in Laravel environments.

- \+ Changes API: adds `Client::boot()`

# v1.0.0

Initial stable release for RiotQuest.
