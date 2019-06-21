<?php

namespace RiotQuest\Components\Framework\Collections;

/**
 * Class Incident
 *
 * @see https://developer.riotgames.com/api-methods/#lol-status-v3/GET_getShardData
 *
 * @property boolean $active Is this incident still active?
 * @property string $created_at Timestamp which holds creating date for incident
 * @property double $id Id for this incident
 * @property MessageList $updates Message updates for this incident
 *
 * @package RiotQuest\Components\Framework\Collections
 */
class Incident extends Collection
{


}
