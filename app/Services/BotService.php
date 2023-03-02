<?php

namespace App\Services;

use TelegramBot\Api\BotApi;

class BotService
{
    private static $instance;

    public static function getInstance()
    {
        if (!self::$instance) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    public $bot;

    public function __construct ()
    {
        $this->bot = new BotApi(BOT_TELEGRAM_TOKEN);
    }
    public static function sendMessage ($message)
    {
        BotService::getInstance()->bot->sendMessage(CHAT_TELEGRAM_ID, $message);
    }
}
