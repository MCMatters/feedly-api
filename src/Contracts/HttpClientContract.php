<?php

declare(strict_types=1);

namespace McMatters\FeedlyApi\Contracts;

/**
 * Interface HttpClientContract
 *
 * @package McMatters\FeedlyApi\Contracts
 */
interface HttpClientContract
{
    /**
     * @param string $uri
     * @param array $query
     * @param array $encodableParameters
     *
     * @return array
     */
    public function get(
        string $uri,
        array $query = [],
        array $encodableParameters = []
    ): array;

    /**
     * @param string $uri
     * @param array $body
     * @param array $encodableParameters
     *
     * @return array
     */
    public function post(
        string $uri,
        array $body,
        array $encodableParameters = []
    ): array;

    /**
     * @param string $uri
     * @param array $body
     * @param array $encodableParameters
     *
     * @return array
     */
    public function put(
        string $uri,
        array $body,
        array $encodableParameters = []
    ): array;

    /**
     * @param string $uri
     * @param array $options
     * @param array $encodableParameters
     *
     * @return bool
     *
     * @throws \McMatters\FeedlyApi\Exceptions\RequestException
     */
    public function delete(
        string $uri,
        array $options = [],
        array $encodableParameters = []
    ): bool;
}
