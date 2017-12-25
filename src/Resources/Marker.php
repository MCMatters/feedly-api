<?php

declare(strict_types = 1);

namespace McMatters\FeedlyApi\Resources;

use McMatters\FeedlyApi\Helpers\StringHelper;
use McMatters\FeedlyApi\Helpers\ValidationHelper;
use const null;
use function array_filter, is_numeric;

/**
 * Class Marker
 *
 * @package McMatters\FeedlyApi\Resources
 */
class Marker extends AbstractResource
{
    /**
     * @param array $query
     *
     * @return array
     * @throws \RuntimeException
     * @throws \McMatters\FeedlyApi\Exceptions\JsonDecodingException
     */
    public function listOfUnreadCounts(array $query = []): array
    {
        return $this->requestGet('/v3/markers/counts', $query);
    }

    /**
     * @param string|array $entryIds
     *
     * @return array
     * @throws \InvalidArgumentException
     * @throws \RuntimeException
     * @throws \McMatters\FeedlyApi\Exceptions\JsonDecodingException
     */
    public function markEntryAsRead($entryIds): array
    {
        return $this->markAs('markAsRead', 'entries', $entryIds);
    }

    /**
     * @param string|array $entryIds
     *
     * @return array
     * @throws \InvalidArgumentException
     * @throws \RuntimeException
     * @throws \McMatters\FeedlyApi\Exceptions\JsonDecodingException
     */
    public function keepEntryAsUnread($entryIds): array
    {
        return $this->markAs('keepUnread', 'entries', $entryIds);
    }

    /**
     * @param string|array $feedIds
     * @param string|int|null $lastRead
     *
     * @return array
     * @throws \InvalidArgumentException
     * @throws \RuntimeException
     * @throws \McMatters\FeedlyApi\Exceptions\JsonDecodingException
     */
    public function markFeedAsRead($feedIds, $lastRead = null): array
    {
        return $this->markAs('markAsRead', 'feeds', $feedIds, $lastRead);
    }

    /**
     * @param string|array $categoryIds
     * @param string|int|null $lastRead
     *
     * @return array
     * @throws \InvalidArgumentException
     * @throws \RuntimeException
     * @throws \McMatters\FeedlyApi\Exceptions\JsonDecodingException
     */
    public function markCategoryAsRead($categoryIds, $lastRead = null): array
    {
        return $this->markAs('markAsRead', 'categories', $categoryIds, $lastRead);
    }

    /**
     * @param string|array $tagIds
     * @param string|int|null $lastRead
     *
     * @return array
     * @throws \InvalidArgumentException
     * @throws \RuntimeException
     * @throws \McMatters\FeedlyApi\Exceptions\JsonDecodingException
     */
    public function markTagAsRead($tagIds, $lastRead = null): array
    {
        return $this->markAs('markAsRead', 'tags', $tagIds, $lastRead);
    }

    /**
     * @param string|array $ids
     * @param string $type
     *
     * @return array
     * @throws \InvalidArgumentException
     * @throws \RuntimeException
     * @throws \McMatters\FeedlyApi\Exceptions\JsonDecodingException
     */
    public function undoMarkAsRead($ids, string $type): array
    {
        ValidationHelper::checkInArray($type, ['categories', 'feeds', 'tags']);

        return $this->markAs('undoMarkAsRead', $type, $ids);
    }

    /**
     * @param string|array $entryIds
     *
     * @return array
     * @throws \InvalidArgumentException
     * @throws \RuntimeException
     * @throws \McMatters\FeedlyApi\Exceptions\JsonDecodingException
     */
    public function markEntryAsSaved($entryIds): array
    {
        return $this->markAs('markAsSaved', 'entries', $entryIds);
    }

    /**
     * @param string|array $entryIds
     *
     * @return array
     * @throws \InvalidArgumentException
     * @throws \RuntimeException
     * @throws \McMatters\FeedlyApi\Exceptions\JsonDecodingException
     */
    public function markEntryAsUnsaved($entryIds): array
    {
        return $this->markAs('markAsUnsaved', 'entries', $entryIds);
    }

    /**
     * @param int|null $newerThan
     *
     * @return array
     * @throws \RuntimeException
     * @throws \McMatters\FeedlyApi\Exceptions\JsonDecodingException
     */
    public function getLatestReadOperations(int $newerThan = null): array
    {
        return $this->requestGet(
            '/v3/markers/reads',
            array_filter(['newerThan' => $newerThan])
        );
    }

    /**
     * @param int|null $newerThan
     *
     * @return array
     * @throws \RuntimeException
     * @throws \McMatters\FeedlyApi\Exceptions\JsonDecodingException
     */
    public function getLatestTaggedEntryIds(int $newerThan = null): array
    {
        return $this->requestGet(
            '/v3/markers/tags',
            array_filter(['newerThan' => $newerThan])
        );
    }

    /**
     * @param string $action
     * @param string $type
     * @param string|array $ids
     * @param string|int|null $lastRead
     *
     * @return array
     * @throws \InvalidArgumentException
     * @throws \RuntimeException
     * @throws \McMatters\FeedlyApi\Exceptions\JsonDecodingException
     */
    protected function markAs(
        string $action,
        string $type,
        $ids,
        $lastRead = null
    ): array {
        ValidationHelper::checkForArrayOrString($ids);

        $typeKey = StringHelper::toSingular($type).'Ids';

        $data = [
            'action' => $action,
            'type'   => $type,
            $typeKey => (array) $ids,
        ];

        if (null !== $lastRead) {
            if (is_numeric($lastRead)) {
                $data['asOf'] = $lastRead;
            } else {
                $data['lastReadEntryId'] = $lastRead;
            }
        }

        return $this->requestPost('/v3/markers', $data);
    }
}
