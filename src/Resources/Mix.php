<?php

declare(strict_types=1);

namespace McMatters\FeedlyApi\Resources;

/**
 * Class Mix
 *
 * @package McMatters\FeedlyApi\Resources
 */
class Mix extends AbstractResource
{
    /**
     * @param string $streamId
     * @param array $query
     *
     * @return array
     */
    public function getMostEngagingContent(
        string $streamId,
        array $query = []
    ): array {
        return $this->httpClient->get(
            'mixes/:streamId:/contents',
            $query,
            ['streamId' => $streamId]
        );
    }
}
