<?php

declare(strict_types = 1);

namespace McMatters\FeedlyApi\Resources;

class GlobalResources extends AbstractResource
{
    protected $userId;

    /**
     * @param string $userId
     *
     * @return void
     */
    public function setUserId(string $userId)
    {
        $uuidPattern = '[0-9A-Fa-f]{8}-[0-9A-Fa-f]{4}-[0-9A-Fa-f]{4}-[0-9A-Fa-f]{4}-[0-9A-Fa-f]{12}';
        $pattern = "/^user\/({$uuidPattern})\/.*/";

        if (\preg_match($pattern, $userId, $match)) {
            $this->userId = $match[1];
        } else {
            $this->userId = $userId;
        }
    }

    public function getUserId()
    {
        if (!$this->userId) {

        }
    }
}
