<?php

namespace SomarKesen\TelegramGateway\Facades;

use Illuminate\Support\Facades\Facade;

class TelegramGateway extends Facade
{
    protected static function getFacadeAccessor()
    {
        // This 'telegram-gateway' is the key that will bind the service in the service container
        return 'telegram-gateway';
    }
}
