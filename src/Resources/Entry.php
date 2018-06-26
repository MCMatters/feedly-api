<?php

declare(strict_types = 1);

namespace McMatters\FeedlyApi\Resources;

/**
 * Class Entry
 *
 * @package McMatters\FeedlyApi\Resources
 */
class Entry extends AbstractResource
{
    /**
     * @param string $id
     *
     * @return array
     * @throws \McMatters\FeedlyApi\Exceptions\JsonDecodingException
     * @throws \McMatters\FeedlyApi\Exceptions\RequestException
     */
    public function get(string $id): array
    {
        return $this->httpClient->get('entries/:id:', [], ['id' => $id]);
    }

    /**
     * @param array $ids
     *
     * @return array
     * @throws \McMatters\FeedlyApi\Exceptions\JsonDecodingException
     * @throws \McMatters\FeedlyApi\Exceptions\RequestException
     */
    public function getForDynamic(array $ids): array
    {
        return $this->httpClient->post('entries/.mget', $ids);
    }

    /**
     * @param string $title
     * @param array $origin
     * @param array $alternate
     * @param array $data
     *
     * @return array
     * @throws \McMatters\FeedlyApi\Exceptions\JsonDecodingException
     * @throws \McMatters\FeedlyApi\Exceptions\RequestException
     */
    public function create(
        string $title,
        array $origin,
        array $alternate,
        array $data
    ): array {
        return $this->httpClient->post(
            'entries',
            [
                'title' => $title,
                'origin' => $origin,
                'alternate' => $alternate,
            ] + $data
        );
    }
}
