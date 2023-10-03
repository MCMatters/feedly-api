<?php

declare(strict_types=1);

namespace McMatters\FeedlyApi\Helpers;

use function str_ends_with;
use function substr;

class StringHelper
{
    protected static array $pluralCache = [];

    public static function toSingular(string $string): string
    {
        if (isset(self::$pluralCache[$string])) {
            return self::$pluralCache[$string];
        }

        if (str_ends_with($string, 'ies')) {
            $plural = substr($string, 0, -3);

            self::$pluralCache[$string] = $plural ? "{$plural}y" : $string;
        } elseif (str_ends_with($string, 's')) {
            self::$pluralCache[$string] = substr($string, 0, -1) ?: $string;
        } else {
            self::$pluralCache[$string] = $string;
        }

        return self::$pluralCache[$string];
    }
}
