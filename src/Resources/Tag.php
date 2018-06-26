<?php

declare(strict_types = 1);

namespace McMatters\FeedlyApi\Resources;

/**
 * Class Tag
 *
 * @package McMatters\FeedlyApi\Resources
 */
class Tag extends AbstractResource
{
    /**
     * @return array
     * @throws \McMatters\FeedlyApi\Exceptions\JsonDecodingException
     * @throws \McMatters\FeedlyApi\Exceptions\RequestException
     */
    public function list(): array
    {
        return $this->httpClient->get('tags');
    }

    /**
     * @param array|string $tag
     * @param array|string $entryId
     *
     * @return array
     * @throws \McMatters\FeedlyApi\Exceptions\JsonDecodingException
     * @throws \McMatters\FeedlyApi\Exceptions\RequestException
     */
    public function tagEntry($tag, $entryId): array
    {
        return $this->httpClient->put(
            'tags/:id:',
            ['entryIds' => $entryId],
            ['id' => $tag]
        );
    }

    /**
     * @param array|string $tag
     * @param array|string $entryId
     *
     * @return bool
     * @throws \McMatters\FeedlyApi\Exceptions\RequestException
     */
    public function untagEntry($tag, $entryId): bool
    {
        return $this->httpClient->delete(
            'tags/:id:/:entryId:',
            [],
            ['id' => $tag, 'entryId' => $entryId]
        );
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
            'tags/:id:',
            ['label' => $label],
            ['id' => $id]
        );
    }

    /**
     * @param array|string $id
     *
     * @return bool
     * @throws \McMatters\FeedlyApi\Exceptions\RequestException
     */
    public function delete($id): bool
    {
        return $this->httpClient->delete('tags/:id:', [], ['id' => $id]);
    }
}
