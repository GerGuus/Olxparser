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
        $this->bot = new BotApi(config("telegram.bot_telegram_token"));
    }
    public static function sendMessage ($message)
    {
        BotService::getInstance()->bot->sendMessage(config("telegram.chat_telegram_id"), $message);
    }
    public static function sendPhoto ($url)
    {
        BotService::getInstance()->bot->sendPhoto(config("telegram.chat_telegram_id"), $url);
    }
}
