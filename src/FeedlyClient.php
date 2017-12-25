<?php

declare(strict_types = 1);

namespace McMatters\FeedlyApi;

use McMatters\FeedlyApi\Exceptions\BadResourceException;
use McMatters\FeedlyApi\Exceptions\BadStorageException;
use McMatters\FeedlyApi\Helpers\StringHelper;
use McMatters\FeedlyApi\Storage\UserStorage;
use function class_exists, strtolower;

/**
 * Class FeedlyClient
 *
 * @package McMatters\FeedlyApi
 */
class FeedlyClient
{
    /**
     * @var string
     */
    protected $oAuthKey;

    /**
     * @var array
     */
    protected $resources = [];

    /**
     * @var array
     */
    protected $storage = [];

    /**
     * FeedlyClient constructor.
     *
     * @param string $oAuthKey
     */
    public function __construct(string $oAuthKey)
    {
        $this->oAuthKey = $oAuthKey;
        $this->setStorage();
    }

    /**
     * @param string $name
     *
     * @return mixed
     * @throws BadResourceException
     */
    public function resource(string $name)
    {
        $lowerCaseName = strtolower($name);

        if (isset($this->resources[$lowerCaseName])) {
            return $this->resources[$lowerCaseName];
        }

        $name = StringHelper::toCamel($name);

        $class = __NAMESPACE__."\\Resources\\{$name}";

        if (!class_exists($class)) {
            throw new BadResourceException();
        }

        $this->resources[$lowerCaseName] = new $class($this->oAuthKey, $this);

        return $this->resources[$lowerCaseName];
    }

    /**
     * @param string $name
     *
     * @return mixed
     * @throws BadStorageException
     */
    public function storage(string $name)
    {
        $name = strtolower($name);

        if (!isset($this->storage[$name])) {
            throw new BadStorageException();
        }

        return $this->storage[$name];
    }

    /**
     * @return void
     */
    protected function setStorage()
    {
        $this->storage = [
            'user' => new UserStorage($this),
        ];
    }
}
