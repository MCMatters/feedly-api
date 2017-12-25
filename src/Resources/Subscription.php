<?php

declare(strict_types = 1);

namespace McMatters\FeedlyApi\Resources;

use McMatters\FeedlyApi\Helpers\StringHelper;
use function array_filter, urlencode;

/**
 * Class Subscription
 *
 * @package McMatters\FeedlyApi\Resources
 */
class Subscription extends AbstractResource
{
    /**
     * @return array
     * @throws \RuntimeException
     * @throws \McMatters\FeedlyApi\Exceptions\JsonDecodingException
     */
    public function list(): array
    {
        return $this->requestGet('/v3/subscriptions');
    }

    /**
     * @param string $feedId
     * @param string|null $title
     * @param array $categories
     *
     * @return array
     * @throws \RuntimeException
     * @throws \McMatters\FeedlyApi\Exceptions\JsonDecodingException
     */
    public function create(
        string $feedId,
        string $title = null,
        array $categories = []
    ): array {
        if (!StringHelper::startsWith($feedId, 'feed/')) {
            $feedId = "feed/{$feedId}";
        }

        return $this->requestPost('/v3/subscriptions', array_filter([
            'id'         => $feedId,
            'title'      => $title,
            'categories' => $categories,
        ]));
    }

    /**
     * @param string $feedId
     * @param array $data
     *
     * @return array
     * @throws \RuntimeException
     * @throws \McMatters\FeedlyApi\Exceptions\JsonDecodingException
     */
    public function update(string $feedId, array $data = []): array
    {
        return $this->create(
            $feedId,
            $data['title'] ?? null,
            $data['categories'] ?? []
        );
    }

    /**
     * @param array $subscriptions
     *
     * @return array
     * @throws \RuntimeException
     * @throws \McMatters\FeedlyApi\Exceptions\JsonDecodingException
     */
    public function updateMultiple(array $subscriptions): array
    {
        return $this->requestPost('/v3/subscriptions/.mput', $subscriptions);
    }

    /**
     * @param string $feedId
     *
     * @return bool
     */
    public function delete(string $feedId): bool
    {
        if (!StringHelper::startsWith($feedId, 'feed/')) {
            $feedId = "feed/{$feedId}";
        }

        $feedId = urlencode($feedId);

        return $this->requestDelete("/v3/subscriptions/{$feedId}");
    }

    /**
     * @param array $feedIds
     *
     * @return bool
     */
    public function deleteMultiple(array $feedIds): bool
    {
        return $this->requestDelete(
            '/v3/subscriptions/.mdelete',
            ['json' => $feedIds]
        );
    }
}
