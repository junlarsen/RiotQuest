<?php

namespace RiotQuest\Components\Framework\Collections;

/**
 * Class ShardStatus
 *
 * @see https://developer.riotgames.com/api-methods/#lol-status-v3/GET_getShardData
 *
 * @property string $name Name of status
 * @property string $region_tag Region of status
 * @property string $hostname Hostname of status
 * @property ServiceList $services List of services
 * @property StringList $locales List of locales
 * @property string $slug Slug of shard
 *
 * @package RiotQuest\Components\Framework\Collections
 */
class ShardStatus extends Collection
{


}
