<?php

declare(strict_types = 1);

namespace McMatters\FeedlyApi\Resources;

/**
 * Class Feed
 *
 * @package McMatters\FeedlyApi\Resources
 */
class Feed extends AbstractResource
{
    /**
     * @param string $id
     *
     * @return array
     * @throws \McMatters\FeedlyApi\Exceptions\JsonDecodingException
     * @throws \McMatters\FeedlyApi\Exceptions\RequestException
     */
    public function getMetadata(string $id): array
    {
        return $this->httpClient->get('feeds/:id:', [], ['id' => $id]);
    }

    /**
     * @param array $ids
     *
     * @return array
     * @throws \McMatters\FeedlyApi\Exceptions\JsonDecodingException
     * @throws \McMatters\FeedlyApi\Exceptions\RequestException
     */
    public function getMetadataForList(array $ids): array
    {
        return $this->httpClient->post('feeds/.mget', $ids);
    }
}
