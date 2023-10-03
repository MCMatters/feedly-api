<?php

declare(strict_types=1);

namespace McMatters\FeedlyApi\Resources;

use const null;

class Subscription extends AbstractResource
{
    public function list(): array
    {
        return $this->httpClient->get('subscriptions');
    }

    public function create(
        string $feedId,
        ?string $title = null,
        array $categories = [],
    ): array {
        return $this->httpClient->post(
            'subscriptions',
            [
                'id' => $feedId,
                'title' => $title,
                'categories' => $categories,
            ],
        );
    }

    public function update(string $feedId, array $data = []): array
    {
        return $this->create(
            $feedId,
            $data['title'] ?? null,
            $data['categories'] ?? [],
        );
    }

    public function updateMultiple(array $data): array
    {
        return $this->httpClient->post('subscriptions/.mput', $data);
    }

    public function delete(string $id): bool
    {
        return $this->httpClient->delete(
            'subscriptions/:id:',
            [],
            ['id' => $id],
        );
    }

    public function deleteMultiple(array $ids): bool
    {
        return $this->httpClient->delete(
            'subscriptions/.mdelete',
            ['json' => $ids],
        );
    }
}
