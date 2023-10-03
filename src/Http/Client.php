<?php

declare(strict_types=1);

namespace McMatters\FeedlyApi\Http;

use McMatters\Ticl\Client as HttpClient;

use Throwable;

use function implode;
use function is_array;
use function is_bool;
use function str_replace;
use function urlencode;

use const false;
use const null;
use const true;

class Client
{
    protected HttpClient $httpClient;

    public function __construct(string $oAuthKey)
    {
        $this->httpClient = new HttpClient([
            'base_uri' => 'https://cloud.feedly.com/v3/',
            'headers' => [
                'Authorization' => "OAuth {$oAuthKey}",
            ],
        ]);
    }

    public function get(
        string $uri,
        array $query = [],
        array $encodableParameters = [],
    ): array {
        return $this->httpClient
            ->withQuery($this->prepareRequestParameters($query))
            ->get($this->buildUri($uri, $encodableParameters))
            ->json();
    }

    public function post(
        string $uri,
        array $body,
        array $encodableParameters = [],
    ): array {
        return $this->httpClient
            ->withJson($body)
            ->post($this->buildUri($uri, $encodableParameters))
            ->json();
    }

    public function put(
        string $uri,
        array $body,
        array $encodableParameters = [],
    ): array {
        return $this->httpClient
            ->withJson($body)
            ->put($this->buildUri($uri, $encodableParameters))
            ->json();
    }

    public function delete(
        string $uri,
        array $options = [],
        array $encodableParameters = [],
    ): bool {
        try {
            $this->httpClient->delete(
                $this->buildUri($uri, $encodableParameters),
                $options,
            );
        } catch (Throwable) {
            return false;
        }

        return true;
    }

    protected function buildUri(
        string $uri,
        array $encodableParameters = [],
    ): string {
        foreach ($encodableParameters as $key => $replacement) {
            $replacement = is_array($replacement)
                ? implode(',', $replacement)
                : (string) $replacement;

            $uri = str_replace(":{$key}:", urlencode($replacement), $uri);
        }

        return $uri;
    }

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
