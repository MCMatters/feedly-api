<?php

declare(strict_types=1);

namespace McMatters\FeedlyApi\Resources;

use const null;

/**
 * Class Category
 *
 * @package McMatters\FeedlyApi\Resources
 */
class Category extends AbstractResource
{
    /**
     * @param string|null $sort
     *
     * @return array
     */
    public function list(string $sort = null): array
    {
        return $this->httpClient->get('categories', ['sort' => $sort]);
    }

    /**
     * @param string $id
     * @param string $label
     *
     * @return array
     */
    public function changeLabel(string $id, string $label): array
    {
        return $this->httpClient->post(
            'categories/:id:',
            ['label' => $label],
            ['id' => $id]
        );
    }

    /**
     * @param string $id
     *
     * @return bool
     */
    public function delete(string $id): bool
    {
        return $this->httpClient->delete('categories/:id:', [], ['id' => $id]);
    }
}
