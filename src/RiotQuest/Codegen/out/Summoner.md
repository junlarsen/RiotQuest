---
title: Summoner
extends: _layouts.documentation
section: content
---

# Summoner

This page describes the methods for the Summoner Collection.

[Collection Source Code](https://github.com/supergrecko/RiotQuest/blob/master/src/RiotQuest/Components/Collections/Summoner.php)

### Method <code>Summoner::getSummonerIcon => string</code>

```php
public function getSummonerIcon( void ): string
```
    
### Method <code>Summoner::getRanked => LeagueEntryList</code>

```php
public function getRanked( int $ttl ): LeagueEntryList
```
    
### Method <code>Summoner::getMatchlist => MatchHistory</code>

```php
public function getMatchlist( int $ttl, array $filters ): MatchHistory
```
    
### Method <code>Summoner::getMasteryScore => int</code>

```php
public function getMasteryScore( int $ttl ): int
```
    
### Method <code>Summoner::getMasteryList => ChampionMasteryList</code>

```php
public function getMasteryList( int $ttl ): ChampionMasteryList
```
    
### Method <code>Summoner::getCurrentGame => CurrentGameInfo</code>

```php
public function getCurrentGame( int $ttl ): CurrentGameInfo
```
    
### Method <code>Summoner::getThirdPartyCode => string</code>

```php
public function getThirdPartyCode( void ): string
```
    
### Method <code>Summoner::isUnranked => bool</code>

```php
public function isUnranked( int $ttl ): bool
```
    
### Method <code>Summoner::isAboveNewPlayerThreshold => bool</code>

```php
public function isAboveNewPlayerThreshold( void ): bool
```
    
