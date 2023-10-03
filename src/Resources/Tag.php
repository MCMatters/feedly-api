<?php

declare(strict_types=1);

namespace McMatters\FeedlyApi\Resources;

class Tag extends AbstractResource
{
    public function list(): array
    {
        return $this->httpClient->get('tags');
    }

    public function tagEntry(array|string $tag, array|string $entryId): array
    {
        return $this->httpClient->put(
            'tags/:id:',
            ['entryIds' => $entryId],
            ['id' => $tag],
        );
    }

    public function untagEntry(array|string $tag, array|string $entryId): bool
    {
        return $this->httpClient->delete(
            'tags/:id:/:entryId:',
            [],
            ['id' => $tag, 'entryId' => $entryId],
        );
    }

    public function changeLabel(string $id, string $label): array
    {
        return $this->httpClient->post(
            'tags/:id:',
            ['label' => $label],
            ['id' => $id],
        );
    }

    public function delete(array|string $id): bool
    {
        return $this->httpClient->delete('tags/:id:', [], ['id' => $id]);
    }
}
