<?php

declare(strict_types = 1);

namespace McMatters\FeedlyApi\Helpers;

use InvalidArgumentException;
use function explode, implode, is_array, is_string, strlen, strpos, str_replace, substr, ucwords;

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
    public static function startsWith(string $haystack, string $needle): bool
    {
        return 0 === strpos($haystack, $needle);
    }

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
     * @param string $string
     *
     * @return string
     */
    public static function toCamel(string $string): string
    {
        return str_replace(' ', '', ucwords(str_replace(['-', '_'], ' ', $string)));
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
            $plural = substr($string, -3);
            self::$pluralCache[$string] = $plural ? "{$plural}y" : $string;
        }

        if (self::endsWith($string, 's')) {
            $plural = substr($string, -1);
            self::$pluralCache[$string] = $plural ?: $string;
        }

        return self::$pluralCache[$string];
    }

    /**
     * @param mixed $item
     *
     * @return string
     * @throws InvalidArgumentException
     */
    public static function toCommaDelimitedString($item): string
    {
        if (is_string($item)) {
            return $item;
        }

        if (is_array($item)) {
            return implode(',', $item);
        }

        throw new InvalidArgumentException('$item must be as an array or a string');
    }

    /**
     * @param mixed $item
     *
     * @return array
     * @throws InvalidArgumentException
     */
    public static function toArrayFromString($item): array
    {
        if (is_array($item)) {
            return $item;
        }

        if (is_string($item)) {
            if (strpos($item, ',')) {
                return explode(',', $item);
            }

            return [$item];
        }

        throw new InvalidArgumentException('$item must be as an array or a string');
    }
}
