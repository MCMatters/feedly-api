<?php

declare(strict_types=1);

namespace McMatters\FeedlyApi;

use McMatters\FeedlyApi\Resources\{
    Category, Entry, Feed, Marker, Mix, Preference, Profile, Search, Stream,
    Subscription, Tag
};

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
     * @return \McMatters\FeedlyApi\Resources\Category
     */
    public function category(): Category
    {
        return $this->resource(Category::class);
    }

    /**
     * @return \McMatters\FeedlyApi\Resources\Entry
     */
    public function entry(): Entry
    {
        return $this->resource(Entry::class);
    }

    /**
     * @return \McMatters\FeedlyApi\Resources\Feed
     */
    public function feed(): Feed
    {
        return $this->resource(Feed::class);
    }

    /**
     * @return \McMatters\FeedlyApi\Resources\Marker
     */
    public function marker(): Marker
    {
        return $this->resource(Marker::class);
    }

    /**
     * @return \McMatters\FeedlyApi\Resources\Mix
     */
    public function mix(): Mix
    {
        return $this->resource(Mix::class);
    }

    /**
     * @return \McMatters\FeedlyApi\Resources\Preference
     */
    public function preference(): Preference
    {
        return $this->resource(Preference::class);
    }

    /**
     * @return \McMatters\FeedlyApi\Resources\Profile
     */
    public function profile(): Profile
    {
        return $this->resource(Profile::class);
    }

    /**
     * @return \McMatters\FeedlyApi\Resources\Search
     */
    public function search(): Search
    {
        return $this->resource(Search::class);
    }

    /**
     * @return \McMatters\FeedlyApi\Resources\Stream
     */
    public function stream(): Stream
    {
        return $this->resource(Stream::class);
    }

    /**
     * @return \McMatters\FeedlyApi\Resources\Subscription
     */
    public function subscription(): Subscription
    {
        return $this->resource(Subscription::class);
    }

    /**
     * @return \McMatters\FeedlyApi\Resources\Tag
     */
    public function tag(): Tag
    {
        return $this->resource(Tag::class);
    }

    /**
     * @param string $class
     *
     * @return mixed
     */
    protected function resource(string $class)
    {
        if (!isset($this->resources[$class])) {
            $this->resources[$class] = new $class($this->oAuthKey, $this);
        }

        return $this->resources[$class];
    }
}
