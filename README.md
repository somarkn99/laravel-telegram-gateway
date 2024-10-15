
# Telegram Gateway Laravel Package

This Laravel package provides an easy-to-use interface for sending verification codes via Telegram using the Telegram Gateway API.

## Installation

1. Install the package via Composer:

```bash
composer require your-vendor/telegram-gateway
```

2. Publish the configuration file:

```bash
php artisan vendor:publish --provider="YourPackage\Providers\TelegramGatewayServiceProvider"
```

3. Add your Telegram API token in the `.env` file:

```bash
TELEGRAM_API_TOKEN=your-telegram-api-token
```

## Configuration

After publishing, you can find the configuration file at `config/telegram_gateway.php`. This file contains the API URL and timeout settings.

```php
return [
    'api_url' => env('TELEGRAM_API_URL', 'https://gatewayapi.telegram.org/'),
    'token' => env('TELEGRAM_API_TOKEN'),
    'timeout' => 30, // Timeout for API requests in seconds
];
```

## Usage

### Sending a Verification Message

To send a verification message, you can use the `TelegramGateway` facade:

```php
use YourPackage\Facades\TelegramGateway;

$response = TelegramGateway::sendVerificationMessage('+1234567890', [
    'code' => '1234',
    'ttl' => 300,
    'callback_url' => 'https://yourapp.com/callback',
]);
```

The `sendVerificationMessage` method accepts the following parameters:
- `phone_number` (string, required): The phone number to which the verification message will be sent.
- `code` (string, optional): The verification code to send. If omitted, Telegram will generate a random code.
- `ttl` (integer, optional): Time-to-live in seconds for the message before it expires.
- `callback_url` (string, optional): URL to receive delivery status updates.

### Available Methods

- `sendVerificationMessage`: Sends a verification message.
- `checkSendAbility`: Check if the message can be sent to a phone number.
- `checkVerificationStatus`: Check the status of a verification message.
- `revokeVerificationMessage`: Revoke a previously sent verification message.

## Testing

To run the tests:

```bash
composer test
```

## License

This package is open-source and available under the MIT license.