<?php

declare(strict_types=1);

namespace McMatters\FeedlyApi\Resources;

use McMatters\FeedlyApi\Http\Client;

abstract class AbstractResource
{
    protected Client $httpClient;

    public function __construct(string $oAuthKey)
    {
        $this->httpClient = new Client($oAuthKey);
    }
}
