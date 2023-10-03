<?php

declare(strict_types=1);

namespace McMatters\FeedlyApi\Resources;

class Feed extends AbstractResource
{
    public function getMetadata(string $id): array
    {
        return $this->httpClient->get('feeds/:id:', [], ['id' => $id]);
    }

    public function getMetadataForList(array $ids): array
    {
        return $this->httpClient->post('feeds/.mget', $ids);
    }
}
