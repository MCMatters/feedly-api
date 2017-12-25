<?php

declare(strict_types = 1);

namespace McMatters\FeedlyApi\Resources;

use function urlencode;

/**
 * Class Stream
 *
 * @package McMatters\FeedlyApi\Resources
 */
class Stream extends AbstractResource
{
    /**
     * @param string $id
     * @param array $query
     *
     * @return array
     * @throws \RuntimeException
     * @throws \McMatters\FeedlyApi\Exceptions\JsonDecodingException
     */
    public function getListOfEntryIds(string $id, array $query = []): array
    {
        $id = urlencode($id);

        return $this->requestGet("/v3/streams/{$id}/ids", $query);
    }

    /**
     * @param string $id
     * @param array $query
     *
     * @return array
     * @throws \RuntimeException
     * @throws \McMatters\FeedlyApi\Exceptions\JsonDecodingException
     */
    public function getContent(string $id, array $query = []): array
    {
        $id = urlencode($id);

        return $this->requestGet("/v3/streams/{$id}/contents", $query);
    }

    /**
     * @param array $query
     * @param string|null $userId
     *
     * @return array
     * @throws \McMatters\FeedlyApi\Exceptions\BadResourceException
     * @throws \RuntimeException
     * @throws \McMatters\FeedlyApi\Exceptions\JsonDecodingException
     */
    public function getSaved(array $query = [], string $userId = null): array
    {
        if (null === $userId) {
            $profile = $this->client->resource('profile')->get();

            $userId = $profile['id'];
        }

        return $this->getContent("user/{$userId}/tag/global.saved", $query);
    }
}
