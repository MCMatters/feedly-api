<?php

declare(strict_types = 1);

namespace McMatters\FeedlyApi\Helpers;

use const null;
use function end;

/**
 * Class ArrayHelper
 *
 * @package McMatters\FeedlyApi\Helpers
 */
class ArrayHelper
{
    /**
     * @param array $array
     *
     * @return mixed
     */
    public static function first(array $array)
    {
        foreach ($array as $item) {
            return $item;
        }

        return null;
    }

    /**
     * @param array $array
     *
     * @return mixed|null
     */
    public static function last(array $array)
    {
        return end($array) ?? null;
    }
}
