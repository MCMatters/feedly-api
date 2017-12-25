<?php

declare(strict_types = 1);

namespace McMatters\FeedlyApi\Resources;

/**
 * Class Preference
 *
 * @package McMatters\FeedlyApi\Resources
 */
class Preference extends AbstractResource
{
    /**
     * @return array
     * @throws \RuntimeException
     * @throws \McMatters\FeedlyApi\Exceptions\JsonDecodingException
     */
    public function get(): array
    {
        return $this->requestGet('/v3/preferences');
    }

    /**
     * @param array $data
     *
     * @return array
     * @throws \RuntimeException
     * @throws \McMatters\FeedlyApi\Exceptions\JsonDecodingException
     */
    public function update(array $data): array
    {
        return $this->requestPost('/v3/preferences', $data);
    }
}
