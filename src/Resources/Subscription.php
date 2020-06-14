<?php

declare(strict_types=1);

namespace McMatters\FeedlyApi\Resources;

/**
 * Class Subscription
 *
 * @package McMatters\FeedlyApi\Resources
 */
class Subscription extends AbstractResource
{
    /**
     * @return array
     */
    public function list(): array
    {
        return $this->httpClient->get('subscriptions');
    }

    /**
     * @param string $feedId
     * @param string|null $title
     * @param array $categories
     *
     * @return array
     */
    public function create(
        string $feedId,
        string $title = null,
        array $categories = []
    ): array {
        return $this->httpClient->post(
            'subscriptions',
            [
                'id' => $feedId,
                'title' => $title,
                'categories' => $categories,
            ]
        );
    }

    /**
     * @param string $feedId
     * @param array $data
     *
     * @return array
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
     * @param array $data
     *
     * @return array
     */
    public function updateMultiple(array $data): array
    {
        return $this->httpClient->post('subscriptions/.mput', $data);
    }

    /**
     * @param string $id
     *
     * @return bool
     */
    public function delete(string $id): bool
    {
        return $this->httpClient->delete(
            'subscriptions/:id:',
            [],
            ['id' => $id]
        );
    }

    /**
     * @param array $ids
     *
     * @return bool
     */
    public function deleteMultiple(array $ids): bool
    {
        return $this->httpClient->delete(
            'subscriptions/.mdelete',
            ['json' => $ids]
        );
    }
}
