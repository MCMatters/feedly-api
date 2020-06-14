<?php

declare(strict_types=1);

namespace McMatters\FeedlyApi\Resources;

use McMatters\FeedlyApi\Http\Client;

/**
 * Class AbstractResource
 *
 * @package McMatters\FeedlyApi\Resources
 */
abstract class AbstractResource
{
    /**
     * @var Client
     */
    protected $httpClient;

    /**
     * AbstractResource constructor.
     *
     * @param string $oAuthKey
     */
    public function __construct(string $oAuthKey)
    {
        $this->httpClient = new Client($oAuthKey);
    }
}
