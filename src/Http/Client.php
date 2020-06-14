<?php

declare(strict_types=1);

namespace McMatters\FeedlyApi\Http;

use McMatters\FeedlyApi\Contracts\HttpClientContract;
use McMatters\Ticl\Client as HttpClient;
use McMatters\Ticl\Enums\HttpStatusCode;

use function implode, is_array, is_bool, str_replace, urlencode;

/**
 * Class Client
 *
 * @package McMatters\FeedlyApi\Http
 */
class Client implements HttpClientContract
{
    /**
     * @var \McMatters\Ticl\Client
     */
    protected $client;

    /**
     * Client constructor.
     *
     * @param string $oAuthKey
     */
    public function __construct(string $oAuthKey)
    {
        $this->client = new HttpClient([
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
     */
    public function get(
        string $uri,
        array $query = [],
        array $encodableParameters = []
    ): array {
        return $this->client
            ->get(
                $this->buildUri($uri, $encodableParameters),
                ['query' => $this->prepareRequestParameters($query)]
            )
            ->json();
    }

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
    ): array {
        return $this->client
            ->post(
                $this->buildUri($uri, $encodableParameters),
                ['json' => $body]
            )
            ->json();
    }

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
    ): array {
        return $this->client
            ->put(
                $this->buildUri($uri, $encodableParameters),
                ['json' => $body]
            )
            ->json();
    }

    /**
     * @param string $uri
     * @param array $options
     * @param array $encodableParameters
     *
     * @return bool
     */
    public function delete(
        string $uri,
        array $options = [],
        array $encodableParameters = []
    ): bool {
        $statusCode = $this->client
            ->delete($this->buildUri($uri, $encodableParameters), $options)
            ->getStatusCode();

        return $statusCode <= HttpStatusCode::OK && $statusCode > HttpStatusCode::BAD_REQUEST;
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
}
