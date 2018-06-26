<?php

declare(strict_types = 1);

namespace McMatters\FeedlyApi;

use McMatters\FeedlyApi\Resources\{
    Category, Entry, Feed, Marker, Mix, Preference, Profile, Search, Stream,
    Subscription, Tag
};
use function ucfirst;

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
     * FeedlyClient constructor.
     *
     * @param string $oAuthKey
     */
    public function __construct(string $oAuthKey)
    {
        $this->oAuthKey = $oAuthKey;
    }

    /**
     * @return Category
     */
    public function category(): Category
    {
        return $this->resource(__FUNCTION__);
    }

    /**
     * @return Entry
     */
    public function entry(): Entry
    {
        return $this->resource(__FUNCTION__);
    }

    /**
     * @return Feed
     */
    public function feed(): Feed
    {
        return $this->resource(__FUNCTION__);
    }

    /**
     * @return Marker
     */
    public function marker(): Marker
    {
        return $this->resource(__FUNCTION__);
    }

    /**
     * @return Mix
     */
    public function mix(): Mix
    {
        return $this->resource(__FUNCTION__);
    }

    /**
     * @return Preference
     */
    public function preference(): Preference
    {
        return $this->resource(__FUNCTION__);
    }

    /**
     * @return Profile
     */
    public function profile(): Profile
    {
        return $this->resource(__FUNCTION__);
    }

    /**
     * @return Search
     */
    public function search(): Search
    {
        return $this->resource(__FUNCTION__);
    }

    /**
     * @return Stream
     */
    public function stream(): Stream
    {
        return $this->resource(__FUNCTION__);
    }

    /**
     * @return Subscription
     */
    public function subscription(): Subscription
    {
        return $this->resource(__FUNCTION__);
    }

    /**
     * @return Tag
     */
    public function tag(): Tag
    {
        return $this->resource(__FUNCTION__);
    }

    /**
     * @param string $name
     *
     * @return mixed
     */
    protected function resource(string $name)
    {
        $name = ucfirst($name);

        if (isset($this->resources[$name])) {
            return $this->resources[$name];
        }

        $class = __NAMESPACE__."\\Resources\\{$name}";

        return $this->resources[$name] = new $class($this->oAuthKey, $this);
    }
}
