<?php

namespace App\Services;

use Twilio\Rest\Client;

class TwilioService
{
    private static $instance;

    public static function getInstance()
    {
        if (!self::$instance) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    public $twilio;

    public function __construct ()
    {
        $this->twilio = new Client(config('twilio_account_sid'), config('twilio_auth_token'));
    }
    public static function sendMessage ($message, $phone)
    {
        TwilioService::getInstance()->twilio->messages->create(
        // Where to send a text message (your cell phone?)
            $phone,
            array(
                'from' => config('twilio_phone'),
                'body' => $message
            )
        );
    }
}
