<?php

namespace App\Services;

use App\Helpers\CallClient;
use GuzzleHttp\Client;

abstract class AbstractCallClient
{
    /**
     * @var Client
     */
    private $client;

    /**
     * @var array
     */
    private $headers;

    public function __construct()
    {
        $this->client = new Client();
        $this->headers = [
            "Content-Type" =>  "application/json",
            "Accept" => "application/json",
        ];
        $this->initialize();
    }

    protected abstract function initialize(): void;

    protected function callClient(string $method, string $url, array $data = []): array
    {
        return CallClient::execute($method, $url, $data, $this->getHeaders());
    }

    protected function callClientWithHeader(string $method, string $url, array $data, array $headers): array
    {
        return CallClient::execute($method, $url, $data, $headers);
    }


    /**
     * @param array $headers
     */
    protected function addHeaders(array $headers): void
    {
        $this->headers = array_merge($this->headers, $headers);
    }

    /**
     * @return array
     */
    public function getHeaders(): array
    {
        return $this->headers;
    }
}
