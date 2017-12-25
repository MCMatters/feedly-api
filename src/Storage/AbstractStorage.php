<?php

declare(strict_types = 1);

namespace McMatters\FeedlyApi\Storage;

use McMatters\FeedlyApi\FeedlyClient;

/**
 * Class AbstractStorage
 *
 * @package McMatters\FeedlyApi\Storage
 */
abstract class AbstractStorage
{
    /**
     * @var FeedlyClient
     */
    protected $client;

    /**
     * AbstractStorage constructor.
     *
     * @param FeedlyClient $client
     */
    public function __construct(FeedlyClient $client)
    {
        $this->client = $client;
    }
}
