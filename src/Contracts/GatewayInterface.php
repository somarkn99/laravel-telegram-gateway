<?php

namespace SomarKesen\TelegramGateway\Contracts;

interface GatewayInterface
{
    public function sendVerificationMessage(string $phoneNumber, array $options = []);
}
