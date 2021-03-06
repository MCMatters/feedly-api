<?php

declare(strict_types=1);

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
     */
    public function get(): array
    {
        return $this->httpClient->get('preferences');
    }

    /**
     * @param array $data
     *
     * @return array
     */
    public function update(array $data): array
    {
        return $this->httpClient->post('preferences', $data);
    }

    /**
     * @param array|string $keys
     *
     * @return array
     */
    public function delete($keys): array
    {
        $data = [];

        foreach ((array) $keys as $key) {
            $data[$key] = '==DELETE==';
        }

        return $this->update($data);
    }
}
