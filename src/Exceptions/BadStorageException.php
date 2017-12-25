<?php

declare(strict_types = 1);

namespace McMatters\FeedlyApi\Exceptions;

use InvalidArgumentException;

/**
 * Class BadStorageException
 *
 * @package McMatters\FeedlyApi\Exceptions
 */
class BadStorageException extends InvalidArgumentException implements FeedlyApiExceptionInterface
{
    /**
     * BadResourceException constructor.
     */
    public function __construct()
    {
        parent::__construct('Bad storage passed');
    }
}
