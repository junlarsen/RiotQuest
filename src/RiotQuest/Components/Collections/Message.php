<?php

namespace RiotQuest\Components\Collections;

use Carbon\Carbon;
use Carbon\CarbonInterface;

/**
 * Class Message
 *
 * @see https://developer.riotgames.com/api-methods/#lol-status-v3/GET_getShardData
 *
 * @property string $severity How severe this incident was
 * @property string $author Who created this message
 * @property string $heading
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

    /**
     * Get a translation by locale code
     *
     * @param string $locale
     * @return mixed
     */
    public function getTranslation(string $locale)
    {
        return $this->filterArr(function (Translation $translation) use ($locale) {
            return $translation->locale === $locale;
        })[$locale];
    }

    /**
     * Get the Carbon interface for creation date
     *
     * @return Carbon|CarbonInterface
     */
    public function getCreationDate()
    {
        return Carbon::createFromTimestampMs($this->created_at);
    }

    /**
     * Get the Carbon interface for last update time
     *
     * @return Carbon|CarbonInterface
     */
    public function getLastUpdateDate()
    {
        return Carbon::createFromTimestampMs($this->updated_at);
    }

}
