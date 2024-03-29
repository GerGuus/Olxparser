<?php

namespace App\Services;

use App\Models\Ad;
use App\Models\Url;
use PHPHtmlParser\Dom;

ini_set("mbstring.regex_retry_limit", "10000000");

class ParserService
{
    public static function getAdInformation($url)
    {
        $dom = new Dom();

        $temp = file_get_contents('https://www.olx.ua' . $url);

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
            'photo' => $photo,
        ];
    }

    public static function getAds(Url $url): array
    {
        $dom = new Dom();

        $dom->loadStr(file_get_contents($url->url));

        $cards = $dom->find('div[data-cy=l-card]');

        $result = [];
        foreach ($cards as $card) {
            $adUrl = $card->find('a', 0)->getAttribute('href');

            print_r($adUrl . "\n");

            $parsedLink = parse_url($adUrl);
            $cleanLink = explode('?', $parsedLink['path'])[0];

            if (Ad::where('ad', $cleanLink)->exists()) {
                continue;
            }
            echo 'work';
            Ad::create(['url_id' => $url->id, 'ad' => $cleanLink]);

            $adInfo = ParserService::getAdInformation($adUrl);
            $result[] = [
                'url' => $adInfo['url'],
                'id' => $adInfo['adId'],
                'title' => $adInfo['title'],
                'description' => $adInfo['description'],
                'time' => $adInfo['time'],
                'person' => $adInfo['person'],
                'photo' => $adInfo['photo'],
            ];
        }

        return $result;
    }
}
