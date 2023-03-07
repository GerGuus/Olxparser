<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\ParserService;
use App\Services\BotService;

class parser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'parser';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {

        $ads = ParserService::getAds('https://www.olx.ua/d/uk/nedvizhimost/kvartiry/prodazha-kvartir/kremenchug/?currency=USD&search%5Border%5D=created_at:desc');

        $message = $ads[0]['url']."\n".$ads[0]['id']."\n".$ads[0]['title']."\n".$ads[0]['description']."\n".$ads[0]['time']."\n".$ads[0]['person'];

        BotService::sendMessage($message);
        BotService::sendPhoto($ads[0]['photo']);

    }
}

