<?php

declare(strict_types=1);

namespace McMatters\FeedlyApi\Exceptions;

use Exception;
use McMatters\FeedlyApi\Contracts\FeedlyApiExceptionContract;

/**
 * Class RequestException
 *
 * @package McMatters\FeedlyApi\Exceptions
 */
class RequestException extends Exception implements FeedlyApiExceptionContract
{
    //
}
