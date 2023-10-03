<?php

declare(strict_types=1);

namespace McMatters\FeedlyApi\Resources;

use const null;

class Search extends AbstractResource
{
    public function findFeeds(
        string $keyword,
        int $count = 20,
        ?string $locale = null,
    ): array {
        return $this->httpClient->get(
            'search/feeds',
            ['query' => $keyword, 'count' => $count, 'locale' => $locale],
        );
    }

    public function searchContentOfStream(
        string $streamId,
        string $keyword,
        array $query = [],
    ): array {
        return $this->httpClient->get(
            'search/:streamId:/contents',
            ['query' => $keyword] + $query,
            ['streamId' => $streamId],
        );
    }
}
