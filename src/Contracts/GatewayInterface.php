<?php

namespace SomarKesen\TelegramGateway\Contracts;

interface GatewayInterface
{
    public function sendVerificationMessage(string $phoneNumber, array $options = []);
    public function checkSendAbility(string $phoneNumber);
    public function checkVerificationStatus(string $request_id, string $code = '');
    public function revokeVerificationMessage(string $request_id);
}
