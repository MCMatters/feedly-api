<?php

declare(strict_types = 1);

namespace McMatters\FeedlyApi\Resources;

/**
 * Class Profile
 *
 * @package McMatters\FeedlyApi\Resources
 */
class Profile extends AbstractResource
{
    /**
     * @return array
     * @throws \RuntimeException
     * @throws \McMatters\FeedlyApi\Exceptions\JsonDecodingException
     */
    public function get(): array
    {
        return $this->requestGet('/v3/profile');
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
        return $this->requestPost('/v3/profile', $data);
    }
}
