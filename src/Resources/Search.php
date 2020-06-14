<?php

declare(strict_types=1);

namespace McMatters\FeedlyApi\Resources;

use const null;

/**
 * Class Search
 *
 * @package McMatters\FeedlyApi\Resources
 */
class Search extends AbstractResource
{
    /**
     * @param string $keyword
     * @param int $count
     * @param string|null $locale
     *
     * @return array
     */
    public function findFeeds(
        string $keyword,
        int $count = 20,
        string $locale = null
    ): array {
        return $this->httpClient->get(
            'search/feeds',
            ['query' => $keyword, 'count' => $count, 'locale' => $locale]
        );
    }

    /**
     * @param string $streamId
     * @param string $keyword
     * @param array $query
     *
     * @return array
     */
    public function searchContentOfStream(
        string $streamId,
        string $keyword,
        array $query = []
    ): array {
        return $this->httpClient->get(
            'search/:streamId:/contents',
            ['query' => $keyword] + $query,
            ['streamId' => $streamId]
        );
    }
}
