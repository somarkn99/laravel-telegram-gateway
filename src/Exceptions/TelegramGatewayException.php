<?php

namespace SomarKesen\TelegramGateway\Exceptions;

use Exception;

class TelegramGatewayException extends Exception
{
    /**
     * Create an exception for invalid access token.
     *
     * @return static
     */
    public static function invalidToken()
    {
        return new static("The provided API token is invalid.");
    }

    /**
     * Create an exception for invalid phone number format.
     *
     * @return static
     */
    public static function invalidPhoneNumber()
    {
        return new static("The provided phone number is in an invalid format.");
    }

    /**
     * Create an exception when the API request fails.
     *
     * @param string $message
     * @return static
     */
    public static function requestFailed($message = "Failed to connect to the Telegram API.")
    {
        return new static($message);
    }
}
