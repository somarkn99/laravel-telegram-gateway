<?php

namespace SomarKesen\TelegramGateway\Tests\Unit;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;
use SomarKesen\TelegramGateway\Services\TelegramGatewayService;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;

class TelegramGatewayTest extends TestCase
{
    public function test_send_verification_message()
    {
        // Create a mock response that simulates the Telegram API's response
        $mock = new MockHandler([
            new Response(200, [], json_encode([
                'ok' => true,
                'result' => 'Verification message sent successfully',
            ])),
        ]);

        // Use the mock handler with Guzzle client
        $handlerStack = HandlerStack::create($mock);
        $client = new Client(['handler' => $handlerStack]);

        // Instantiate the TelegramGatewayService with the mocked client
        $service = new TelegramGatewayService($client);

        // Call the sendVerificationMessage method
        $response = $service->sendVerificationMessage('+1234567890');

        // Assert that the response contains the expected 'ok' value
        $this->assertTrue($response['ok']);
    }
}
