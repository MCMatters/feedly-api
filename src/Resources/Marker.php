<?php

declare(strict_types = 1);

namespace McMatters\FeedlyApi\Resources;

use McMatters\FeedlyApi\Helpers\StringHelper;
use const null;
use function is_numeric;

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
     * @throws \McMatters\FeedlyApi\Exceptions\JsonDecodingException
     * @throws \McMatters\FeedlyApi\Exceptions\RequestException
     */
    public function listOfUnreadCounts(array $query = []): array
    {
        return $this->httpClient->get('markers/counts', $query);
    }

    /**
     * @param array|string $entryId
     *
     * @return array
     * @throws \McMatters\FeedlyApi\Exceptions\JsonDecodingException
     * @throws \McMatters\FeedlyApi\Exceptions\RequestException
     */
    public function markEntryAsRead($entryId): array
    {
        return $this->markAsRead('entries', $entryId);
    }

    /**
     * @param array|string $entryId
     *
     * @return array
     * @throws \McMatters\FeedlyApi\Exceptions\JsonDecodingException
     * @throws \McMatters\FeedlyApi\Exceptions\RequestException
     */
    public function keepEntryUnread($entryId): array
    {
        return $this->markAs('keepUnread', 'entries', $entryId);
    }

    /**
     * @param array|string $feedId
     * @param string $lastReadEntryId
     *
     * @return array
     * @throws \McMatters\FeedlyApi\Exceptions\JsonDecodingException
     * @throws \McMatters\FeedlyApi\Exceptions\RequestException
     */
    public function markFeedAsRead($feedId, string $lastReadEntryId): array
    {
        return $this->markAsRead('feeds', $feedId, $lastReadEntryId);
    }

    /**
     * @param array|string $categoryId
     * @param string $lastReadEntryId
     *
     * @return array
     * @throws \McMatters\FeedlyApi\Exceptions\JsonDecodingException
     * @throws \McMatters\FeedlyApi\Exceptions\RequestException
     */
    public function markCategoryAsRead(
        $categoryId,
        string $lastReadEntryId
    ): array {
        return $this->markAsRead('categories', $categoryId, $lastReadEntryId);
    }

    /**
     * @param array|string $tagId
     * @param string $lastReadEntryId
     *
     * @return array
     * @throws \McMatters\FeedlyApi\Exceptions\JsonDecodingException
     * @throws \McMatters\FeedlyApi\Exceptions\RequestException
     */
    public function markTagAsRead($tagId, string $lastReadEntryId): array
    {
        return $this->markAsRead('tags', $tagId, $lastReadEntryId);
    }

    /**
     * @param array|string $feedId
     *
     * @return array
     * @throws \McMatters\FeedlyApi\Exceptions\JsonDecodingException
     * @throws \McMatters\FeedlyApi\Exceptions\RequestException
     */
    public function undoMarkFeedAsRead($feedId): array
    {
        return $this->undoMarkAsRead('feeds', $feedId);
    }

    /**
     * @param array|string $categoryId
     *
     * @return array
     * @throws \McMatters\FeedlyApi\Exceptions\JsonDecodingException
     * @throws \McMatters\FeedlyApi\Exceptions\RequestException
     */
    public function undoMarkCategoryAsRead($categoryId): array
    {
        return $this->undoMarkAsRead('categories', $categoryId);
    }

    /**
     * @param array|string $tagId
     *
     * @return array
     * @throws \McMatters\FeedlyApi\Exceptions\JsonDecodingException
     * @throws \McMatters\FeedlyApi\Exceptions\RequestException
     */
    public function undoMarkTagAsRead($tagId): array
    {
        return $this->undoMarkAsRead('tags', $tagId);
    }

    /**
     * @param array|string $entryId
     *
     * @return array
     * @throws \McMatters\FeedlyApi\Exceptions\JsonDecodingException
     * @throws \McMatters\FeedlyApi\Exceptions\RequestException
     */
    public function markEntryAsSaved($entryId): array
    {
        return $this->markAs('markAsSaved', 'entries', $entryId);
    }

    /**
     * @param array|string $entryId
     *
     * @return array
     * @throws \McMatters\FeedlyApi\Exceptions\JsonDecodingException
     * @throws \McMatters\FeedlyApi\Exceptions\RequestException
     */
    public function markEntryAsUnsaved($entryId): array
    {
        return $this->markAs('markAsUnsaved', 'entries', $entryId);
    }

    /**
     * @param float|null $newerThan
     *
     * @return array
     * @throws \McMatters\FeedlyApi\Exceptions\JsonDecodingException
     * @throws \McMatters\FeedlyApi\Exceptions\RequestException
     */
    public function getLatestReadOperations(float $newerThan = null): array
    {
        return $this->httpClient->get(
            'markers/reads',
            ['newerThan' => $newerThan]
        );
    }

    /**
     * @param float|null $newerThan
     *
     * @return array
     * @throws \McMatters\FeedlyApi\Exceptions\JsonDecodingException
     * @throws \McMatters\FeedlyApi\Exceptions\RequestException
     */
    public function getLatestTaggedEntryIds(float $newerThan = null): array
    {
        return $this->httpClient->get(
            'markers/tags',
            ['newerThan' => $newerThan]
        );
    }

    /**
     * @param string $type
     * @param array|string $id
     * @param null $lastRead
     *
     * @return array
     * @throws \McMatters\FeedlyApi\Exceptions\JsonDecodingException
     * @throws \McMatters\FeedlyApi\Exceptions\RequestException
     */
    protected function markAsRead(string $type, $id, $lastRead = null): array
    {
        return $this->markAs('markAsRead', $type, $id, $lastRead);
    }

    /**
     * @param string $type
     * @param array|string $id
     *
     * @return array
     * @throws \McMatters\FeedlyApi\Exceptions\JsonDecodingException
     * @throws \McMatters\FeedlyApi\Exceptions\RequestException
     */
    protected function undoMarkAsRead(string $type, $id): array
    {
        return $this->markAs('undoMarkAsRead', $type, $id);
    }

    /**
     * @param string $action
     * @param string $type
     * @param array|string $id
     * @param null $lastRead
     *
     * @return array
     * @throws \McMatters\FeedlyApi\Exceptions\JsonDecodingException
     * @throws \McMatters\FeedlyApi\Exceptions\RequestException
     */
    protected function markAs(
        string $action,
        string $type,
        $id,
        $lastRead = null
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
