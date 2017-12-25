<?php

declare(strict_types = 1);

namespace McMatters\FeedlyApi\Resources;

use const false;
use function urlencode;

/**
 * Class Category
 *
 * @package McMatters\FeedlyApi\Resources
 */
class Category extends AbstractResource
{
    /**
     * @param bool $feedlyOrdering
     *
     * @return array
     * @throws \RuntimeException
     * @throws \McMatters\FeedlyApi\Exceptions\JsonDecodingException
     */
    public function list(bool $feedlyOrdering = false): array
    {
        return $this->requestGet(
            '/v3/categories',
            $feedlyOrdering ? ['sort' => 'feedly'] : []
        );
    }

    /**
     * @param string $id
     * @param string $label
     *
     * @return array
     * @throws \RuntimeException
     * @throws \McMatters\FeedlyApi\Exceptions\JsonDecodingException
     */
    public function changeLabel(string $id, string $label): array
    {
        $id = urlencode($id);

        return $this->requestPost("/v3/categories/{$id}", ['label' => $label]);
    }

    /**
     * @param string $id
     *
     * @return bool
     */
    public function delete(string $id): bool
    {
        $id = urlencode($id);

        return $this->requestDelete("/v3/categories/{$id}");
    }
}
