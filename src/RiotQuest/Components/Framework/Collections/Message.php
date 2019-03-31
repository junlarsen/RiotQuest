<?php

namespace RiotQuest\Components\Framework\Collections;

/**
 * Class Message
 *
 * @see https://developer.riotgames.com/api-methods/#lol-status-v3/GET_getShardData
 *
 * @property string $severity How severe this incident was
 * @property string $author Who created this message
 * @property string $created_at When was this message created
 * @property TranslationList $translations Translations of message
 * @property string $updated_at Last time message was updated
 * @property string $content Contents of message
 * @property string $id ID of message
 *
 * @package RiotQuest\Components\Framework\Collections
 */
class Message extends Collection
{



}
