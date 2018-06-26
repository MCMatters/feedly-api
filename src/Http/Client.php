<?php

declare(strict_types = 1);

namespace McMatters\FeedlyApi\Http;

use GuzzleHttp\Client as BaseClient;
use McMatters\FeedlyApi\Contracts\HttpClientContract;
use McMatters\FeedlyApi\Exceptions\JsonDecodingException;
use McMatters\FeedlyApi\Exceptions\RequestException;
use Throwable;
use const true;
use const JSON_ERROR_NONE;
use function json_decode, json_last_error, json_last_error_msg, implode,
    is_array, is_bool, str_replace, trim, urlencode;

/**
 * Class Client
 *
 * @package McMatters\FeedlyApi\Http
 */
class Client implements HttpClientContract
{
    /**
     * @var BaseClient
     */
    protected $client;

    /**
     * Client constructor.
     *
     * @param string $oAuthKey
     */
    public function __construct(string $oAuthKey)
    {
        $this->client = new BaseClient([
            'base_uri' => 'https://cloud.feedly.com/v3/',
            'headers' => [
                'Authorization' => "OAuth {$oAuthKey}",
            ],
        ]);
    }

    /**
     * @param string $uri
     * @param array $query
     * @param array $encodableParameters
     *
     * @return array
     * @throws \McMatters\FeedlyApi\Exceptions\RequestException
     * @throws \McMatters\FeedlyApi\Exceptions\JsonDecodingException
     */
    public function get(
        string $uri,
        array $query = [],
        array $encodableParameters = []
    ): array {
        try {
            $response = $this->client->get(
                $this->buildUri($uri, $encodableParameters),
                ['query' => $this->prepareRequestParameters($query)]
            );

            $content = $response->getBody()->getContents();
        } catch (Throwable $exception) {
            throw new RequestException(
                $exception->getMessage(),
                $exception->getCode(),
                $exception
            );
        }

        return $this->parseResponse($content);
    }

    /**
     * @param string $uri
     * @param array $body
     * @param array $encodableParameters
     *
     * @return array
     * @throws \McMatters\FeedlyApi\Exceptions\RequestException
     * @throws \McMatters\FeedlyApi\Exceptions\JsonDecodingException
     */
    public function post(
        string $uri,
        array $body,
        array $encodableParameters = []
    ): array {
        try {
            $response = $this->client->post(
                $this->buildUri($uri, $encodableParameters),
                ['json' => $body]
            );

            $content = $response->getBody()->getContents();
        } catch (Throwable $exception) {
            throw new RequestException(
                $exception->getMessage(),
                $exception->getCode(),
                $exception
            );
        }

        return $this->parseResponse($content);
    }

    /**
     * @param string $uri
     * @param array $body
     * @param array $encodableParameters
     *
     * @return array
     * @throws \McMatters\FeedlyApi\Exceptions\RequestException
     * @throws \McMatters\FeedlyApi\Exceptions\JsonDecodingException
     */
    public function put(
        string $uri,
        array $body,
        array $encodableParameters = []
    ): array {
        try {
            $response = $this->client->put(
                $this->buildUri($uri, $encodableParameters),
                ['json' => $body]
            );

            $content = $response->getBody()->getContents();
        } catch (Throwable $exception) {
            throw new RequestException(
                $exception->getMessage(),
                $exception->getCode(),
                $exception
            );
        }

        return $this->parseResponse($content);
    }

    /**
     * @param string $uri
     * @param array $options
     * @param array $encodableParameters
     *
     * @return bool
     * @throws \McMatters\FeedlyApi\Exceptions\RequestException
     */
    public function delete(
        string $uri,
        array $options = [],
        array $encodableParameters = []
    ): bool {
        try {
            $response = $this->client->delete(
                $this->buildUri($uri, $encodableParameters),
                $options
            );

            $statusCode = $response->getStatusCode();

            return $statusCode <= 200 && $statusCode > 400;
        } catch (Throwable $exception) {
            throw new RequestException(
                $exception->getMessage(),
                $exception->getCode(),
                $exception
            );
        }
    }

    /**
     * @param string $uri
     * @param array $encodableParameters
     *
     * @return string
     */
    protected function buildUri(
        string $uri,
        array $encodableParameters = []
    ): string {
        foreach ($encodableParameters as $key => $replacement) {
            $replacement = is_array($replacement)
                ? implode(',', $replacement)
                : $replacement;

            $uri = str_replace(":{$key}:", urlencode($replacement), $uri);
        }

        return $uri;
    }

    /**
     * @param array $parameters
     *
     * @return array
     */
    protected function prepareRequestParameters(array $parameters = []): array
    {
        $prepared = [];

        foreach ($parameters as $name => $parameter) {
            if (null === $parameter) {
                continue;
            }

            if (is_bool($parameter)) {
                $parameter = $parameter ? 'true' : 'false';
            }

            $prepared[$name] = urlencode(
                is_array($parameter)
                    ? implode(',', $parameter)
                    : (string) $parameter
            );
        }

        return $prepared;
    }

    /**
     * @param string $content
     *
     * @return array
     * @throws \McMatters\FeedlyApi\Exceptions\JsonDecodingException
     */
    protected function parseResponse(string $content): array
    {
        $content = trim($content);

        if ('' === $content) {
            return [];
        }

        $content = json_decode($content, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new JsonDecodingException(json_last_error_msg());
        }

        return $content;
    }
}
