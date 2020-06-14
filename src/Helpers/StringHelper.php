<?php

declare(strict_types=1);

namespace McMatters\FeedlyApi\Helpers;

use function strlen, substr;

/**
 * Class StringHelper
 *
 * @package McMatters\FeedlyApi\Helpers
 */
class StringHelper
{
    /**
     * @var array
     */
    protected static $pluralCache = [];

    /**
     * @param string $haystack
     * @param string $needle
     *
     * @return bool
     */
    public static function endsWith(string $haystack, string $needle): bool
    {
        return substr($haystack, -strlen($needle)) === $needle;
    }

    /**
     * Base implementation of converting plural form of string to singular.
     *
     * @param string $string
     *
     * @return bool|string
     */
    public static function toSingular(string $string)
    {
        if (isset(self::$pluralCache[$string])) {
            return self::$pluralCache[$string];
        }

        self::$pluralCache[$string] = $string;

        if (self::endsWith($string, 'ies')) {
            $plural = substr($string, 0, -3);
            self::$pluralCache[$string] = $plural ? "{$plural}y" : $string;
        } elseif (self::endsWith($string, 's')) {
            $plural = substr($string, 0, -1);
            self::$pluralCache[$string] = $plural ?: $string;
        }

        return self::$pluralCache[$string];
    }
}
