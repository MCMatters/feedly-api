<?php

declare(strict_types=1);

namespace McMatters\FeedlyApi;

use McMatters\FeedlyApi\Resources\Category;
use McMatters\FeedlyApi\Resources\Entry;
use McMatters\FeedlyApi\Resources\Feed;
use McMatters\FeedlyApi\Resources\Marker;
use McMatters\FeedlyApi\Resources\Mix;
use McMatters\FeedlyApi\Resources\Preference;
use McMatters\FeedlyApi\Resources\Profile;
use McMatters\FeedlyApi\Resources\Search;
use McMatters\FeedlyApi\Resources\Stream;
use McMatters\FeedlyApi\Resources\Subscription;
use McMatters\FeedlyApi\Resources\Tag;

class FeedlyClient
{
    protected array $resources = [];

    public function __construct(protected string $oAuthKey)
    {
    }

    public function category(): Category
    {
        return $this->resource(Category::class);
    }

    public function entry(): Entry
    {
        return $this->resource(Entry::class);
    }

    public function feed(): Feed
    {
        return $this->resource(Feed::class);
    }

    public function marker(): Marker
    {
        return $this->resource(Marker::class);
    }

    public function mix(): Mix
    {
        return $this->resource(Mix::class);
    }

    public function preference(): Preference
    {
        return $this->resource(Preference::class);
    }

    public function profile(): Profile
    {
        return $this->resource(Profile::class);
    }

    public function search(): Search
    {
        return $this->resource(Search::class);
    }

    public function stream(): Stream
    {
        return $this->resource(Stream::class);
    }

    public function subscription(): Subscription
    {
        return $this->resource(Subscription::class);
    }

    public function tag(): Tag
    {
        return $this->resource(Tag::class);
    }

    protected function resource(string $class)
    {
        if (!isset($this->resources[$class])) {
            $this->resources[$class] = new $class($this->oAuthKey, $this);
        }

        return $this->resources[$class];
    }
}
