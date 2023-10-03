<?php

declare(strict_types=1);

namespace McMatters\FeedlyApi\Resources;

class Profile extends AbstractResource
{
    public function get(): array
    {
        return $this->httpClient->get('profile');
    }

    public function update(array $data): array
    {
        return $this->httpClient->post('profile', $data);
    }
}
