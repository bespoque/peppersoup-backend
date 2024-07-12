<?php

namespace App\Helpers;

use App\Exceptions\ApplicationException;
use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Support\Facades\Log;

class CallClient
{
    /**
     * @param string $method
     * @param string $url
     * @param array $data
     * @param array $headers
     * @return array
     * @throws GuzzleException
     */
    public static function execute(string $method, string $url, array $data, array $headers): array
    {
        $client = new Client(["timeout" => 120]);

        $options = [
            "headers" => $headers,
            "json" => $data
        ];


        try {
            $response = match (strtoupper($method)) {
                "POST" => $client->post($url, $options),
                "PUT" => $client->put($url, $options),
                default => $client->get($url, $options),
            };

            $responseBody = $response->getBody()->getContents();
        } catch (RequestException $exception) {
            $responseBody = $exception->getResponse()->getBody()->getContents();
        } catch (Exception $exception) {
            Log::error($exception->getMessage(), $exception->getTrace());

            throw new ApplicationException("Oops! Something went wrong internally. Please try again later.");
        }

        return json_decode($responseBody, true);
    }
}
