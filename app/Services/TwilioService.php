<?php

namespace App\Services;

use Twilio\Rest\Client;

class TwilioService
{
    public $twilio;
    private static $instance;

    public function __construct()
    {
        $this->twilio = new Client(config('twilio.twilio_account_sid'), config('twilio.twilio_auth_token'));
    }

    public static function getInstance()
    {
        if (!self::$instance) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    public static function sendMessage($message, $phone)
    {
        TwilioService::getInstance()->twilio->messages->create(
            // Where to send a text message (your cell phone?)
            $phone,
            [
                'from' => config('twilio.twilio_phone'),
                'body' => $message,
            ]
        );
    }
}
