<?php

declare(strict_types = 1);

namespace McMatters\FeedlyApi\Resources;

use const true;
use function array_key_exists, array_merge;

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
     * @throws \McMatters\FeedlyApi\Exceptions\JsonDecodingException
     * @throws \McMatters\FeedlyApi\Exceptions\RequestException
     */
    public function listOfEntryIds(string $id, array $query = []): array
    {
        return $this->httpClient->get('streams/:id:/ids', $query, ['id' => $id]);
    }

    /**
     * @param string $id
     * @param array $query
     *
     * @return array
     * @throws \McMatters\FeedlyApi\Exceptions\JsonDecodingException
     * @throws \McMatters\FeedlyApi\Exceptions\RequestException
     */
    public function getContent(string $id, array $query = []): array
    {
        return $this->httpClient->get(
            'streams/:id:/contents',
            $query,
            ['id' => $id]
        );
    }

    /**
     * @param string $userId
     * @param array $query
     *
     * @return array
     * @throws \McMatters\FeedlyApi\Exceptions\JsonDecodingException
     * @throws \McMatters\FeedlyApi\Exceptions\RequestException
     */
    public function getSaved(string $userId, array $query = []): array
    {
        return $this->getContent("user/{$userId}/tag/global.saved", $query);
    }

    /**
     * @param string $userId
     * @param array $query
     *
     * @return array
     * @throws \McMatters\FeedlyApi\Exceptions\JsonDecodingException
     * @throws \McMatters\FeedlyApi\Exceptions\RequestException
     */
    public function getAllSaved(string $userId, array $query = []): array
    {
        $items = [];

        $query['count'] = 1000;

        while (true) {
            $data = $this->getSaved($userId, $query);
            $items[] = $data['items'];

            if (!array_key_exists('continuation', $data)) {
                break;
            }

            $query['continuation'] = $data['continuation'];
        }

        return array_merge([], ...$items);
    }
}
