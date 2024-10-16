
# Telegram Gateway Laravel Package

This Laravel package provides an easy-to-use interface for sending verification codes via Telegram using the Telegram Gateway API.

## Installation

1. Install the package via Composer:

```bash
composer require somarkesen/telegram-gateway
```

2. Publish the configuration file:

```bash
php artisan vendor:publish --provider="SomarKesen\TelegramGateway\Providers\TelegramGatewayServiceProvider"
```

3. Add your Telegram API token in the `.env` file:

```bash
TELEGRAM_API_TOKEN=your-telegram-api-token
```

### Obtaining the Telegram API Token:
To use this package, you need to get an API token from Telegram Gateway.

1. Visit the Telegram Gateway API page: [https://gateway.telegram.org/](https://gateway.telegram.org/).
2. Log in using your **Telegram phone number**.
3. After logging in, you will be able to **fund your account** and view your **API token**.
4. Copy the token and add it to your Laravel `.env` file as shown above.

> Ensure your account is funded and your API token is valid, as this token will be required for all API requests.

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
use SomarKesen\TelegramGateway\Facades\TelegramGateway;

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

### Checking Send Ability

To check whether a verification message can be sent to a phone number:

```php
$response = TelegramGateway::checkSendAbility('+1234567890');
```

### Checking Verification Status

To check the status of a verification message that was sent previously:

```php
$response = TelegramGateway::checkVerificationStatus('request-id', '1234');
```

The `checkVerificationStatus` method accepts:
- `request_id` (string, required): The unique identifier of the verification request.
- `code` (string, optional): The code entered by the user. This can verify if the code is valid.

### Revoking a Verification Message

To revoke a previously sent verification message:

```php
$response = TelegramGateway::revokeVerificationMessage('request-id');
```

The `revokeVerificationMessage` method accepts:
- `request_id` (string, required): The unique identifier of the verification request to revoke.

## Available Methods

- **sendVerificationMessage**: Sends a verification message.
- **checkSendAbility**: Checks if a verification message can be sent to a phone number.
- **checkVerificationStatus**: Checks the status of a previously sent verification message.
- **revokeVerificationMessage**: Revokes a previously sent verification message.

## Testing

To run the tests:

```bash
composer test
```

## Credits

- [Somar kesen](https://www.linkedin.com/in/somarkesen/)
- [Yhya Nesb](https://www.linkedin.com/in/yhya-nesb/)

## License

This package is open-source and available under the MIT license.