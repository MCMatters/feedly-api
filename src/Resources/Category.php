<?php

declare(strict_types=1);

namespace McMatters\FeedlyApi\Resources;

use const null;

class Category extends AbstractResource
{
    public function list(?string $sort = null): array
    {
        return $this->httpClient->get('categories', ['sort' => $sort]);
    }

    public function changeLabel(string $id, string $label): array
    {
        return $this->httpClient->post(
            'categories/:id:',
            ['label' => $label],
            ['id' => $id],
        );
    }

    public function delete(string $id): bool
    {
        return $this->httpClient->delete('categories/:id:', [], ['id' => $id]);
    }
}
