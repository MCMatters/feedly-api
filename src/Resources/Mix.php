<?php

declare(strict_types=1);

namespace McMatters\FeedlyApi\Resources;

class Mix extends AbstractResource
{
    public function getMostEngagingContent(
        string $streamId,
        array $query = [],
    ): array {
        return $this->httpClient->get(
            'mixes/:streamId:/contents',
            $query,
            ['streamId' => $streamId],
        );
    }
}
