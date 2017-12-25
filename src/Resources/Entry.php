<?php

declare(strict_types = 1);

namespace McMatters\FeedlyApi\Resources;

use InvalidArgumentException;
use McMatters\FeedlyApi\Helpers\ValidationHelper;
use function urlencode;

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
     * @throws \RuntimeException
     * @throws \McMatters\FeedlyApi\Exceptions\JsonDecodingException
     */
    public function getContent(string $id): array
    {
        $id = urlencode($id);

        return $this->requestGet("/v3/entries/{$id}");
    }

    /**
     * @param array $ids
     *
     * @return array
     * @throws InvalidArgumentException
     * @throws \RuntimeException
     * @throws \McMatters\FeedlyApi\Exceptions\JsonDecodingException
     */
    public function getContentForDynamicList(array $ids): array
    {
        ValidationHelper::checkCountOfArray($ids, 1000, 'entry ids');

        return $this->requestPost('/v3/entries/.mget', $ids);
    }

    /**
     * @param string $title
     * @param array $origin
     * @param array $alternate
     * @param array $data
     *
     * @return array
     * @throws InvalidArgumentException
     * @throws \RuntimeException
     * @throws \McMatters\FeedlyApi\Exceptions\JsonDecodingException
     */
    public function create(
        string $title,
        array $origin,
        array $alternate,
        array $data
    ): array {
        ValidationHelper::checkArrayKeysExistence(
            $data,
            ['content', 'summary', 'enclosure']
        );

        $data = array_merge(
            $data,
            ['title' => $title, 'origin' => $origin, 'alternate' => $alternate]
        );

        return $this->requestPost('/v3/entries/', $data);
    }
}
