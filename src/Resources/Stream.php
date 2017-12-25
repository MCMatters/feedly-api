<?php

declare(strict_types = 1);

namespace McMatters\FeedlyApi\Resources;

use const true;
use function array_key_exists, array_merge, urlencode;

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
     * @throws \McMatters\FeedlyApi\Exceptions\BadStorageException
     * @throws \RuntimeException
     * @throws \McMatters\FeedlyApi\Exceptions\JsonDecodingException
     */
    public function getSaved(array $query = [], string $userId = null): array
    {
        if (null === $userId) {
            $userId = $this->client->storage('user')->getId();
        }

        return $this->getContent("user/{$userId}/tag/global.saved", $query);
    }

    /**
     * @param array $query
     * @param string|null $userId
     *
     * @return array
     * @throws \McMatters\FeedlyApi\Exceptions\BadStorageException
     * @throws \RuntimeException
     * @throws \McMatters\FeedlyApi\Exceptions\JsonDecodingException
     */
    public function getAllSaved(array $query = [], string $userId = null): array
    {
        $items = [];

        // If "count" not present, then we set it as 1000 for saving queries to feedly.
        $query['count'] = $query['count'] ?? 1000;

        while (true) {
            $data = $this->getSaved($query, $userId);
            $items[] = $data['items'];

            if (!array_key_exists('continuation', $data)) {
                break;
            }

            $query['continuation'] = $data['continuation'];
        }

        return array_merge([], ...$items);
    }
}
