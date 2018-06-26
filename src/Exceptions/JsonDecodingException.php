<?php

declare(strict_types = 1);

namespace McMatters\FeedlyApi\Exceptions;

use Exception;
use McMatters\FeedlyApi\Contracts\FeedlyApiExceptionContract;

/**
 * Class JsonDecodingException
 *
 * @package McMatters\FeedlyApi\Exceptions
 */
class JsonDecodingException extends Exception implements FeedlyApiExceptionContract
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
