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
     * @throws \McMatters\FeedlyApi\Exceptions\JsonDecodingException
     * @throws \McMatters\FeedlyApi\Exceptions\RequestException
     */
    public function get(): array
    {
        return $this->httpClient->get('profile');
    }

    /**
     * @param array $data
     *
     * @return array
     * @throws \McMatters\FeedlyApi\Exceptions\JsonDecodingException
     * @throws \McMatters\FeedlyApi\Exceptions\RequestException
     */
    public function update(array $data): array
    {
        return $this->httpClient->post('profile', $data);
    }
}
