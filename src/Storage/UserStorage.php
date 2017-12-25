<?php

declare(strict_types = 1);

namespace McMatters\FeedlyApi\Storage;

use const null;
use function preg_match;

/**
 * Class UserStorage
 *
 * @package McMatters\FeedlyApi\Storage
 */
class UserStorage extends AbstractStorage
{
    /**
     * @var string|null
     */
    protected $id;

    /**
     * @return string|null
     * @throws \McMatters\FeedlyApi\Exceptions\BadResourceException
     */
    public function getId()
    {
        if (null === $this->id) {
            $this->client->resource('profile')->get();
        }

        return $this->id;
    }

    /**
     * @param string $id
     *
     * @return void
     */
    public function setId(string $id)
    {
        if (null !== $this->id) {
            return;
        }

        $uuidPattern = '[0-9A-Fa-f]{8}-[0-9A-Fa-f]{4}-[0-9A-Fa-f]{4}-[0-9A-Fa-f]{4}-[0-9A-Fa-f]{12}';
        $pattern = "/^user\/({$uuidPattern})\/.*/";

        if (preg_match($pattern, $id, $match)) {
            $this->id = $match[1];
        } else {
            $this->id = $id;
        }
    }
}
