<?php

declare(strict_types = 1);

namespace McMatters\FeedlyApi\Exceptions;

use Exception;

/**
 * Class JsonDecodingException
 *
 * @package McMatters\FeedlyApi\Exceptions
 */
class JsonDecodingException extends Exception implements FeedlyApiExceptionInterface
{
    /**
     * JsonDecodingException constructor.
     *
     * @param string $message
     */
    public function __construct(string $message)
    {
        parent::__construct($message);
    }
}
