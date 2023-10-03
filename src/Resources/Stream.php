<?php

declare(strict_types=1);

namespace McMatters\FeedlyApi\Resources;

use function array_key_exists;
use function array_merge;

use const true;

class Stream extends AbstractResource
{
    public function listOfEntryIds(string $id, array $query = []): array
    {
        return $this->httpClient->get('streams/:id:/ids', $query, ['id' => $id]);
    }

    public function getContent(string $id, array $query = []): array
    {
        return $this->httpClient->get(
            'streams/:id:/contents',
            $query,
            ['id' => $id],
        );
    }

    public function getSaved(string $userId, array $query = []): array
    {
        return $this->getContent("user/{$userId}/tag/global.saved", $query);
    }

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
