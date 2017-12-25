<?php

declare(strict_types = 1);

namespace McMatters\FeedlyApi\Resources;

use InvalidArgumentException;
use McMatters\FeedlyApi\Helpers\{
    ArrayHelper, StringHelper, ValidationHelper
};
use function urlencode;

/**
 * Class Tag
 *
 * @package McMatters\FeedlyApi\Resources
 */
class Tag extends AbstractResource
{
    /**
     * @return array
     * @throws \RuntimeException
     * @throws \McMatters\FeedlyApi\Exceptions\JsonDecodingException
     * @throws \McMatters\FeedlyApi\Exceptions\BadStorageException
     */
    public function list(): array
    {
        $tags = $this->requestGet('/v3/tags');

        $tag = ArrayHelper::first($tags);
        $this->client->storage('user')->setId($tag['id']);

        return $tags;
    }

    /**
     * @param mixed $tag Can be either an array or a comma-separated string.
     *
     * @return bool
     * @throws InvalidArgumentException
     */
    public function delete($tag): bool
    {
        ValidationHelper::checkForArrayOrString($tag);
        $tags = urlencode(StringHelper::toCommaDelimitedString($tag));

        return $this->requestDelete("/v3/tags/{$tags}");
    }

    /**
     * @param mixed $tag Can be either an array or a comma-separated string.
     * @param mixed $entry Can be either an array or a comma-separated string.
     *
     * @return array
     * @throws InvalidArgumentException
     * @throws \RuntimeException
     * @throws \McMatters\FeedlyApi\Exceptions\JsonDecodingException
     */
    public function tagEntry($tag, $entry): array
    {
        ValidationHelper::checkForArrayOrString($tag);
        ValidationHelper::checkForArrayOrString($entry);

        $tags = urlencode(StringHelper::toCommaDelimitedString($tag));
        $entries = StringHelper::toArrayFromString($entry);

        return $this->requestPut("/v3/tags/{$tags}", ['entryIds' => $entries]);
    }

    /**
     * @param mixed $tag Can be either an array or a comma-separated string.
     * @param mixed $entry Can be either an array or a comma-separated string.
     *
     * @return bool
     * @throws InvalidArgumentException
     */
    public function untagEntry($tag, $entry): bool
    {
        ValidationHelper::checkForArrayOrString($tag);
        ValidationHelper::checkForArrayOrString($entry);

        $tags = urlencode(StringHelper::toCommaDelimitedString($tag));
        $entries = urlencode(StringHelper::toCommaDelimitedString($entry));

        return $this->requestDelete("/v3/tags/{$tags}/{$entries}");
    }

    /**
     * @param string $id
     * @param string $label
     *
     * @return array
     * @throws InvalidArgumentException
     * @throws \RuntimeException
     * @throws \McMatters\FeedlyApi\Exceptions\JsonDecodingException
     */
    public function changeLabel(string $id, string $label): array
    {
        ValidationHelper::checkLabelName($label);

        return $this->requestPost("/v3/tags/{$id}", ['label' => $label]);
    }
}
