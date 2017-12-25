<?php

declare(strict_types = 1);

namespace McMatters\FeedlyApi\Resources;

use GuzzleHttp\Client;
use McMatters\FeedlyApi\Exceptions\JsonDecodingException;
use McMatters\FeedlyApi\FeedlyClient;
use Psr\Http\Message\ResponseInterface;
use RuntimeException;
use const true, JSON_ERROR_NONE;
use function json_decode, json_last_error, json_last_error_msg, trim;

/**
 * Class AbstractResource
 *
 * @package McMatters\FeedlyApi\Resources
 */
abstract class AbstractResource
{
    /**
     * @var Client
     */
    protected $httpClient;

    /**
     * @var null|ResponseInterface
     */
    protected $lastResponse;

    /**
     * @var FeedlyClient
     */
    protected $client;

    /**
     * AbstractResource constructor.
     *
     * @param string $oAuthKey
     * @param FeedlyClient $client
     */
    public function __construct(string $oAuthKey, FeedlyClient $client)
    {
        $this->httpClient = new Client([
            'base_uri' => 'https://cloud.feedly.com/',
            'headers'  => [
                'Authorization' => "OAuth {$oAuthKey}",
            ],
        ]);

        $this->client = $client;
    }

    /**
     * @param string $uri
     * @param array $query
     *
     * @return array
     * @throws RuntimeException
     * @throws JsonDecodingException
     */
    protected function requestGet(string $uri, array $query = []): array
    {
        $response = $this->request('get', $uri, ['query' => $query]);

        return $this->parseJson($response->getBody()->getContents());
    }

    /**
     * @param string $uri
     * @param array $data
     *
     * @return array
     * @throws RuntimeException
     * @throws JsonDecodingException
     */
    protected function requestPost(string $uri, array $data = []): array
    {
        $response = $this->request('post', $uri, ['json' => $data]);

        return $this->parseJson($response->getBody()->getContents());
    }

    /**
     * @param string $uri
     * @param array $data
     *
     * @return array
     * @throws RuntimeException
     * @throws JsonDecodingException
     */
    protected function requestPut(string $uri, array $data): array
    {
        $response = $this->request('put', $uri, ['json' => $data]);

        return $this->parseJson($response->getBody()->getContents());
    }

    /**
     * @param string $uri
     * @param array $options
     *
     * @return bool
     */
    protected function requestDelete(string $uri, array $options = []): bool
    {
        $response = $this->request('delete', $uri, $options);

        $code = $response->getStatusCode();

        return $code >= 200 && $code < 300;
    }

    /**
     * @param string $method
     * @param string $uri
     * @param array $options
     *
     * @return ResponseInterface
     */
    protected function request(
        string $method,
        string $uri,
        array $options = []
    ): ResponseInterface {
        $response = $this->httpClient->request($method, $uri, $options);

        $this->lastResponse = $response;

        return $response;
    }

    /**
     * @param string $content
     *
     * @return array
     * @throws JsonDecodingException
     */
    protected function parseJson(string $content): array
    {
        $content = trim($content);

        if ('' === $content) {
            return [];
        }

        $data = json_decode($content, true);

        if (JSON_ERROR_NONE !== json_last_error()) {
            throw new JsonDecodingException(json_last_error_msg());
        }

        return $data;
    }
}
