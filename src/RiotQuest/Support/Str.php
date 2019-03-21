<?php

namespace RiotQuest\Support;

/**
 * Class Str
 *
 * Simplifies string operations
 *
 * @package RiotQuest\Support
 */
class Str
{

    /**
     * Matches a string with { placeholders } and replaces
     * them by name with the $replace.
     *
     * @param $subject
     * @param $replace
     * @return string|string[]|null
     */
    public static function replace($subject, $replace)
    {
        return preg_replace_callback('/\{(\w+)\}/', function ($matches) use ($replace) {
            return $replace[$matches[1]];
        }, $subject);
    }

}
