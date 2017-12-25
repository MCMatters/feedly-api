<?php

declare(strict_types = 1);

namespace McMatters\FeedlyApi\Resources;

use function urlencode;

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
     * @throws \RuntimeException
     * @throws \McMatters\FeedlyApi\Exceptions\JsonDecodingException
     */
    public function getMostEngagingContent(
        string $streamId,
        array $query = []
    ): array {
        $streamId = urlencode($streamId);

        return $this->requestGet("/v3/mixes/{$streamId}/contents", $query);
    }
}
