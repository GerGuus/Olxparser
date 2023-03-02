<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use PHPHtmlParser\Dom;
use TelegramBot\Api\BotApi;

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

        // Create a new Dom object
        $dom = new Dom;

        // Load the HTML from the URL
        
        $temp = file_get_contents('https://www.olx.ua/d/uk/nedvizhimost/kvartiry/prodazha-kvartir/kremenchug/?currency=USD&search%5Border%5D=created_at:desc');
        $dom->loadStr($temp);


        // Find all divs with data-cy="l-card"
        $cards = $dom->find('div[data-cy=l-card]');
        // Loop through the list of cards and extract the data
        $result = array();
        foreach ($cards as $card) {
            $url = $card->find('a', 0)->getAttribute('href');
            $adInfo = $this->getInformation($url);
            $result[] = array(
                'url' => $adInfo['url'],
                'id' => $adInfo['adId'],
                'title' => $adInfo['title'],
                'description' => $adInfo['description'],
                'time' => $adInfo['time'],
                'person' => $adInfo['person'],
                'photo' => $adInfo['photo']
            );
        }

        $token = '6062462129:AAEYt1XMaJkWfMGWO-jUygxxnC4plx64SQs';
        $chat_id = '653375326';

        $bot = new BotApi($token);

        
        $message = $result[0]['url']."\n".$result[0]['id']."\n".$result[0]['title']."\n".$result[0]['description']."\n".$result[0]['time']."\n".$result[0]['person'];

        $bot->sendMessage($chat_id, $message);

        $photo_url = $result[0]['photo'];

        $url = "https://api.telegram.org/bot".$token."/sendPhoto";
        $post_fields = array('chat_id' => $chat_id, 'photo' => $result[0]['photo']);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            "Content-Type:multipart/form-data"
        ));
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_fields);
        $result = curl_exec($ch);
        curl_close($ch);

        var_dump($result);
    }
    private function getInformation($url){
        $dom = new Dom;

        $temp = file_get_contents('https://www.olx.ua'.$url);

        $dom->loadStr($temp);

        $adId = $dom->find('div[data-cy=ad-footer-bar-section]')->find('span', 0)->text;

        $title = $dom->find('h1[data-cy=ad_title]')->text;

        $description = $dom->find('div[data-cy=ad_description]')->find('div', 0)->text;

        $time = $dom->find('span[data-cy=ad-posted-at]')->text;

        $person = $dom->find('div[class=css-1fp4ipz]')->find('h4', 0)->text;

        $photo = $dom->find('div[class=swiper-zoom-container]')->find('img', 0)->src;

        return [
            'url' => $url,
            'adId' => $adId,
            'title' => $title,
            'description' => $description,
            'time' => $time,
            'person' => $person,
            'photo' => $photo];
    }   

}

