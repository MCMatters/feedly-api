<?php

declare(strict_types = 1);

namespace McMatters\FeedlyApi\Resources;

use function urlencode;

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
     * @throws \RuntimeException
     * @throws \McMatters\FeedlyApi\Exceptions\JsonDecodingException
     */
    public function getMetadata(string $id): array
    {
        $id = urlencode($id);

        return $this->requestGet("/v3/feeds/{$id}");
    }

    /**
     * @param array $ids
     *
     * @return array
     * @throws \RuntimeException
     * @throws \McMatters\FeedlyApi\Exceptions\JsonDecodingException
     */
    public function getMetadataForList(array $ids): array
    {
        return $this->requestPost('/v3/feeds/.mget', $ids);
    }
}
