<?php

declare(strict_types = 1);

namespace McMatters\FeedlyApi\Resources;

use McMatters\FeedlyApi\Helpers\ValidationHelper;
use const null;
use function array_filter, array_merge;

/**
 * Class Search
 *
 * @package McMatters\FeedlyApi\Resources
 */
class Search extends AbstractResource
{
    /**
     * @param string $keyword
     * @param string|null $locale
     * @param int $count
     *
     * @return array
     * @throws \InvalidArgumentException
     * @throws \RuntimeException
     * @throws \McMatters\FeedlyApi\Exceptions\JsonDecodingException
     */
    public function searchFeeds(
        string $keyword,
        string $locale = null,
        int $count = 20
    ): array {
        ValidationHelper::checkRequired($keyword);

        return $this->requestGet(
            '/v3/search/feeds',
            array_filter([
                'query'  => $keyword,
                'count'  => $count,
                'locale' => $locale,
            ])
        );
    }

    /**
     * @param string $streamId
     * @param string $keyword
     * @param array $query
     *
     * @return array
     * @throws \InvalidArgumentException
     * @throws \RuntimeException
     * @throws \McMatters\FeedlyApi\Exceptions\JsonDecodingException
     */
    public function searchContentOfStream(
        string $streamId,
        string $keyword,
        array $query = []
    ): array {
        ValidationHelper::checkRequired($keyword);

        return $this->requestGet(
            "/v3/search/{$streamId}/contents",
            array_merge($query, ['query' => $keyword])
        );
    }
}
