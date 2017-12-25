<?php

declare(strict_types = 1);

namespace McMatters\FeedlyApi\Helpers;

use InvalidArgumentException;
use const false, true;
use function array_key_exists, count, in_array, is_array, is_string, strpos, trim;

/**
 * Class ValidationHelper
 *
 * @package McMatters\FeedlyApi\Helpers
 */
class ValidationHelper
{
    /**
     * @param array $items
     * @param int $max
     * @param string $name
     *
     * @return void
     * @throws InvalidArgumentException
     */
    public static function checkCountOfArray(
        array $items,
        int $max,
        string $name = 'items'
    ) {
        if (count($items) > $max) {
            throw new InvalidArgumentException(
                "Maximum allowed {$name} is {$max}"
            );
        }
    }

    /**
     * @param array $array
     * @param string|array $keys
     *
     * @return void
     * @throws InvalidArgumentException
     */
    public static function checkArrayKeysExistence(array $array, $keys)
    {
        self::checkForArrayOrString($keys, '$keys');

        foreach ((array) $keys as $key) {
            if (!array_key_exists($key, $array)) {
                throw new InvalidArgumentException(
                    "{$key} is not present in array"
                );
            }
        }
    }

    /**
     * @param mixed $item
     * @param string $name
     *
     * @return void
     * @throws InvalidArgumentException
     */
    public static function checkForArrayOrString($item, string $name = 'Item')
    {
        if (!is_string($item) && !is_array($item)) {
            throw new InvalidArgumentException(
                "{$name} must be as an array or a string"
            );
        }
    }

    /**
     * @param string $label
     *
     * @return void
     * @throws InvalidArgumentException
     */
    public static function checkLabelName(string $label)
    {
        $disallowedCharacters = ['“', '<', '>', '?', '&', '/', '\\', '^'];

        foreach ($disallowedCharacters as $character) {
            if (strpos($label, $character) !== false) {
                throw new InvalidArgumentException(
                    "Label cannot contain '{$character}' character."
                );
            }
        }
    }

    /**
     * @param mixed $needle
     * @param array $array
     *
     * @return void
     * @throws InvalidArgumentException
     */
    public static function checkInArray($needle, array $array)
    {
        if (!in_array($needle, $array, true)) {
            throw new InvalidArgumentException("There is no {$needle} in array");
        }
    }

    /**
     * @param mixed $item
     * @param string|null $name
     *
     * @return void
     * @throws InvalidArgumentException
     */
    public static function checkRequired($item, string $name = null)
    {
        if (null === $item ||
            (is_array($item) && !$item) ||
            (is_string($item) && '' === trim($item))
        ) {
            $name = null !== $name ? " {$name} " : ' ';

            throw new InvalidArgumentException("Variable{$name}is required");
        }
    }
}
