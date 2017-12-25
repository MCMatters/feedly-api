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
     * @throws \McMatters\FeedlyApi\Exceptions\BadStorageException
     */
    public function get(): array
    {
        $profile = $this->requestGet('/v3/profile');

        $this->client->storage('user')->setId($profile['id']);

        return $profile;
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
