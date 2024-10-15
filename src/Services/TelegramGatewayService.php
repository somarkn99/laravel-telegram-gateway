<?php

namespace SomarKesen\TelegramGateway\Services;

use GuzzleHttp\Client;
use YourPackage\Exceptions\TelegramGatewayException;

class TelegramGatewayService
{
    protected $client;
    protected $apiUrl;
    protected $token;

    public function __construct(Client $client)
    {
        $this->client = $client;
        $this->apiUrl = config('telegram_gateway.api_url');
        $this->token = config('telegram_gateway.token');
    }

    public function sendVerificationMessage(string $phoneNumber, array $options = [])
    {
        $endpoint = "{$this->apiUrl}/sendVerificationMessage";
        return $this->makeRequest('POST', $endpoint, array_merge([
            'phone_number' => $phoneNumber
        ], $options));
    }

    protected function makeRequest(string $method, string $url, array $data = [])
    {
        try {
            $response = $this->client->request($method, $url, [
                'headers' => [
                    'Authorization' => "Bearer {$this->token}",
                    'Accept' => 'application/json',
                ],
                'json' => $data,
                'timeout' => config('telegram_gateway.timeout'),
            ]);

            return json_decode($response->getBody()->getContents(), true);
        } catch (\GuzzleHttp\Exception\ClientException $e) {
            // Handle specific API errors
            throw TelegramGatewayException::requestFailed($e->getMessage());
        } catch (\Exception $e) {
            // General error handling
            throw new TelegramGatewayException("An unexpected error occurred: " . $e->getMessage());
        }
    }
}
