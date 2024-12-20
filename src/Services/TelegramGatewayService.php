<?php

namespace SomarKesen\TelegramGateway\Services;

use GuzzleHttp\Client;
use SomarKesen\TelegramGateway\Exceptions\TelegramGatewayException;
use SomarKesen\TelegramGateway\Contracts\GatewayInterface;

class TelegramGatewayService implements GatewayInterface
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

    /**
     * Use this method to send a verification message. Charges will apply according to the pricing plan for each successful message delivery. Note that this method is always free of charge when used to send codes to your own phone number. On success, returns a RequestStatus object.
     * @param string $phoneNumber The phone number to which you want to send a verification message, in the E.164 format.
     * @param array $options options are:
     * 
     * `string request_id` The unique identifier of a previous request from checkSendAbility. If provided, this request will be free of charge.
     * 
     * `string sender_username` Username of the Telegram channel from which the code will be sent. The specified channel, if any, must be verified and owned by the same account who owns the Gateway API token.
     * 
     * `string code` The verification code. Use this parameter if you want to set the verification code yourself. Only fully numeric strings between 4 and 8 characters in length are supported. If this parameter is set, code_length is ignored.
     * 
     * `int code_length` An HTTPS URL where you want to receive delivery reports related to the sent message, 0-256 bytes.
     * 
     * `string payload` Custom payload, 0-128 bytes. This will not be displayed to the user, use it for your internal processes.
     * 
     * `int ttl` Time-to-live (in seconds) before the message expires and is deleted. The message will not be deleted if it has already been read. If not specified, the message will not be deleted. Supported values are from 60 to 86400.
     * 
     * @link https://core.telegram.org/gateway/api#sendverificationmessage
     * @return mixed
     */
    public function sendVerificationMessage(string $phoneNumber, array $options = [])
    {
        $endpoint = "{$this->apiUrl}/sendVerificationMessage";
        return $this->makeRequest('POST', $endpoint, array_merge([
            'phone_number' => $phoneNumber
        ], $options));
    }

    /**
     * Use this method to optionally check the ability to send a verification message to the specified phone number.
     * If the ability to send is confirmed, a fee will apply according to the pricing plan. After checking, you can 
     * send a verification message using the sendVerificationMessage method, providing the request_id from this response.
     * 
     * @param string $phoneNumber The phone number for which you want to check our ability to send a verification message, in the E.164 format.
     * @link https://core.telegram.org/gateway/api#checksendability
     * @return mixed
     */
    public function checkSendAbility(string $phoneNumber)
    {
        // Correct endpoint based on the documentation
        $endpoint = "{$this->apiUrl}/checkSendAbility";

        $data = [
            'phone_number' => $phoneNumber, // Phone number in E.164 format
        ];

        return $this->makeRequest('POST', $endpoint, $data);
    }


    /**
     * Use this method to check the status of a verification message that was sent previously.
     * If the code was generated by Telegram, you can also verify the correctness of the code entered by the user using this method.
     * Even if you set the code yourself, it is recommended to call this method after the user has successfully entered the code, 
     * passing the correct code in the code parameter so that the conversion rate can be tracked.
     * 
     * @param string $request_id The unique identifier of the verification request whose status you want to check.
     * @param string $code The code entered by the user. If provided, the method checks if the code is valid for the relevant request.
     * @link https://core.telegram.org/gateway/api#checkverificationstatus
     * @return mixed
     */
    public function checkVerificationStatus(string $request_id, string $code = '')
    {
        // Correct endpoint based on the documentation
        $endpoint = "{$this->apiUrl}/checkVerificationStatus";

        $data = [
            'request_id' => $request_id,
            'code' => $code, // The code entered by the user
        ];

        return $this->makeRequest('POST', $endpoint, $data);
    }


    /**
     * Use this method to revoke a verification message that was sent previously.
     * Returns True if the revocation request was received. However, this does not guarantee that the message will be deleted.
     * For example, it will not be removed if the recipient has already read it.
     *
     * @param string $request_id The unique identifier of the verification request whose status you want to revoke.
     * @link https://core.telegram.org/gateway/api#revokeverificationmessage
     * @return mixed
     */
    public function revokeVerificationMessage(string $request_id)
    {
        // Correct endpoint based on the documentation
        $endpoint = "{$this->apiUrl}/revokeVerificationMessage";

        $data = [
            'request_id' => $request_id, // The request ID of the message you want to revoke
        ];

        return $this->makeRequest('POST', $endpoint, $data);
    }

    /**
     * Sends an HTTP request to the specified URL using the given method and data.
     *
     * @param string $method The HTTP method to use (e.g., GET, POST).
     * @param string $url The endpoint URL to which the request is sent.
     * @param array $data Optional data to send with the request, formatted as JSON.
     * 
     * @return mixed The decoded JSON response from the API.
     * 
     * @throws TelegramGatewayException If the request fails due to client errors or other exceptions.
     * 
     */
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
