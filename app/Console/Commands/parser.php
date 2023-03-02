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
        ini_set("mbstring.regex_retry_limit", "10000000");

        $ads = ParserService::getAds('https://www.olx.ua/d/uk/nedvizhimost/kvartiry/prodazha-kvartir/kremenchug/?currency=USD&search%5Border%5D=created_at:desc');

        $message = $ads[0]['url']."\n".$ads[0]['id']."\n".$ads[0]['title']."\n".$ads[0]['description']."\n".$ads[0]['time']."\n".$ads[0]['person'];

        BotService::sendMessage($message);

        // $url = "https://api.telegram.org/bot".$token."/sendPhoto";
        // $post_fields = array('chat_id' => $chat_id, 'photo' => $result[0]['photo']);

        // $ch = curl_init();
        // curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        //     "Content-Type:multipart/form-data"
        // ));
        // curl_setopt($ch, CURLOPT_URL, $url);
        // curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        // curl_setopt($ch, CURLOPT_POSTFIELDS, $post_fields);
        // $result = curl_exec($ch);
        // curl_close($ch);

        var_dump($result);
    }
}

