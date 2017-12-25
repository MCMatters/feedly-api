<?php

declare(strict_types = 1);

namespace McMatters\FeedlyApi\Exceptions;

use InvalidArgumentException;

/**
 * Class BadResourceException
 *
 * @package McMatters\FeedlyApi\Exceptions
 */
class BadResourceException extends InvalidArgumentException implements FeedlyApiExceptionInterface
{
    /**
     * BadResourceException constructor.
     */
    public function __construct()
    {
        parent::__construct('Bad resource passed');
    }
}
