<?php

declare(strict_types=1);

namespace McMatters\FeedlyApi\Resources;

class Entry extends AbstractResource
{
    public function get(string $id): array
    {
        return $this->httpClient->get('entries/:id:', [], ['id' => $id]);
    }

    public function getForDynamic(array $ids): array
    {
        return $this->httpClient->post('entries/.mget', $ids);
    }

    public function create(
        string $title,
        array $origin,
        array $alternate,
        array $data,
    ): array {
        return $this->httpClient->post(
            'entries',
            [
                'title' => $title,
                'origin' => $origin,
                'alternate' => $alternate,
            ] + $data,
        );
    }
}
