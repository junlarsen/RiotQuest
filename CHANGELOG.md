# v1.2.3-beta

This is a beta release which tests whether the framework is 100% functional with the Framework folder refactor.

Would not run in production.

- \- src/RiotQuest/Components/Framework has been flattened to parent directory

# v1.2.2

This release replaces the internal code generator used for DTO's. There are no changes for the consumer.

There has also been a couple code style fixes.

- \+ New Codegen
- \- Old Codegen

# v1.2.1

Moves the old LeaguePosition and LeaguePositionList helpers into the new LeagueEntry(List) classes.

Cleans up codestyle across entire project.

- \+ Adds new methods to LeagueEntry & LeagueEntryList
- \+ Codestyle across entire project

# v1.2.0

Turns the application class into a singleton. Adds type declarations where it's possible.

This means that RiotQuest will not be functional for PHP 7.0. You need to use PHP 7.1+

- \- PHP 7.0 Support
- \+ Type Declarations for most functions

# v1.1.5

This removes the deprecated /lol/league/v4/positions/by-summoner/{encryptedSummonerId} endpoint and replaces it with the new one.

- \+ New League endpoint
- \- Deprecated endpoints

# v1.1.4

Fixes issue with Symfony\DotEnv

- \+ Bugfix

# v1.1.3

Fixes issue with Summoner->getProfileIcon

- \+ Bugfix

# v1.1.2

Adds the new LeagueEntries endpoint and removes one environment variable

- \+ Adds new LeagueEntries endpoint
- \- RIOTQUEST_LOAD_ENV variable removed because you're forced to use the env.

# v1.1.1-beta

Replaces a few old modules (API unchanged) and fixes some datadragon stuff


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

This release marks the initial release of RiotQuest
