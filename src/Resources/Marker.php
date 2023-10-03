<?php

declare(strict_types=1);

namespace McMatters\FeedlyApi\Resources;

use McMatters\FeedlyApi\Helpers\StringHelper;

use function is_numeric;

use const null;

class Marker extends AbstractResource
{
    public function listOfUnreadCounts(array $query = []): array
    {
        return $this->httpClient->get('markers/counts', $query);
    }

    public function markEntryAsRead(array|string $entryId): array
    {
        return $this->markAsRead('entries', $entryId);
    }

    public function keepEntryUnread(array|string $entryId): array
    {
        return $this->markAs('keepUnread', 'entries', $entryId);
    }

    public function markFeedAsRead(
        array|string $feedId,
        string $lastReadEntryId,
    ): array {
        return $this->markAsRead('feeds', $feedId, $lastReadEntryId);
    }

    public function markCategoryAsRead(
        array|string $categoryId,
        string $lastReadEntryId,
    ): array {
        return $this->markAsRead('categories', $categoryId, $lastReadEntryId);
    }

    public function markTagAsRead(
        array|string $tagId,
        string $lastReadEntryId,
    ): array {
        return $this->markAsRead('tags', $tagId, $lastReadEntryId);
    }

    public function undoMarkFeedAsRead(array|string $feedId): array
    {
        return $this->undoMarkAsRead('feeds', $feedId);
    }

    public function undoMarkCategoryAsRead(array|string $categoryId): array
    {
        return $this->undoMarkAsRead('categories', $categoryId);
    }

    public function undoMarkTagAsRead(array|string $tagId): array
    {
        return $this->undoMarkAsRead('tags', $tagId);
    }

    public function markEntryAsSaved(array|string $entryId): array
    {
        return $this->markAs('markAsSaved', 'entries', $entryId);
    }

    public function markEntryAsUnsaved(array|string $entryId): array
    {
        return $this->markAs('markAsUnsaved', 'entries', $entryId);
    }

    public function getLatestReadOperations(?float $newerThan = null): array
    {
        return $this->httpClient->get(
            'markers/reads',
            ['newerThan' => $newerThan],
        );
    }

    public function getLatestTaggedEntryIds(?float $newerThan = null): array
    {
        return $this->httpClient->get(
            'markers/tags',
            ['newerThan' => $newerThan],
        );
    }

    protected function markAsRead(
        string $type,
        array|string $id,
        int|string|null $lastRead = null,
    ): array {
        return $this->markAs('markAsRead', $type, $id, $lastRead);
    }

    protected function undoMarkAsRead(string $type, array|string $id): array
    {
        return $this->markAs('undoMarkAsRead', $type, $id);
    }

    protected function markAs(
        string $action,
        string $type,
        array|string $id,
        int|string|null $lastRead = null,
    ): array {
        $typeKey = StringHelper::toSingular($type).'Ids';

        $data = [
            'action' => $action,
            'type' => $type,
            $typeKey => (array) $id,
        ];

        if (null !== $lastRead) {
            if (is_numeric($lastRead)) {
                $data['asOf'] = $lastRead;
            } else {
                $data['lastReadEntryId'] = $lastRead;
            }
        }

        return $this->httpClient->post('markers', $data);
    }
}
