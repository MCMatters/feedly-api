<?php

declare(strict_types = 1);

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
     * @throws \McMatters\FeedlyApi\Exceptions\JsonDecodingException
     * @throws \McMatters\FeedlyApi\Exceptions\RequestException
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
     * @throws \McMatters\FeedlyApi\Exceptions\JsonDecodingException
     * @throws \McMatters\FeedlyApi\Exceptions\RequestException
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
     * @throws \McMatters\FeedlyApi\Exceptions\RequestException
     */
    public function delete(string $id): bool
    {
        return $this->httpClient->delete('categories/:id:', [], ['id' => $id]);
    }
}
