<?php

namespace SomarKesen\TelegramGateway\Providers;

use Illuminate\Support\ServiceProvider;
use SomarKesen\TelegramGateway\Services\TelegramGatewayService;

class TelegramGatewayServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton('telegram-gateway', function () {
            return new TelegramGatewayService(new \GuzzleHttp\Client);
        });
    }

    public function boot()
    {
        // Publish the config file, if needed
        $this->publishes([
            __DIR__.'/../../config/telegram_gateway.php' => config_path('telegram_gateway.php'),
        ]);
    }
}
