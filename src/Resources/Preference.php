<?php

declare(strict_types=1);

namespace McMatters\FeedlyApi\Resources;

class Preference extends AbstractResource
{
    public function get(): array
    {
        return $this->httpClient->get('preferences');
    }

    public function update(array $data): array
    {
        return $this->httpClient->post('preferences', $data);
    }

    public function delete(array|string $keys): array
    {
        $data = [];

        foreach ((array) $keys as $key) {
            $data[$key] = '==DELETE==';
        }

        return $this->update($data);
    }
}
