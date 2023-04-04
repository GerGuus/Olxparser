<?php

namespace Tests\Unit;

use App\Services\ParserService;
use PHPHtmlParser\Dom;
use PHPUnit\Framework\TestCase;

class ParseTest extends TestCase
{
    public function testGetAdInformation()
    {
        $dom = new Dom();

        $dom->loadStr(file_get_contents('https://www.olx.ua/d/uk/nedvizhimost/kvartiry/prodazha-kvartir/kremenchug/?currency=USD&search%5Border%5D=created_at:desc'));

        $ad = $dom->find('div[data-cy=l-card]');

        $adUrl = $ad->find('a', 0)->getAttribute('href');

        $result = ParserService::getAdInformation($adUrl);

        $this->assertIsArray($result);
        $this->assertArrayHasKey('url', $result);
        $this->assertArrayHasKey('adId', $result);
        $this->assertArrayHasKey('title', $result);
        $this->assertArrayHasKey('description', $result);
        $this->assertArrayHasKey('time', $result);
        $this->assertArrayHasKey('person', $result);
        $this->assertArrayHasKey('photo', $result);
    }

    public function testGetAds()
    {
        $url = 'https://www.olx.ua/d/uk/nedvizhimost/kvartiry/prodazha-kvartir/kremenchug/?currency=USD&search%5Border%5D=created_at:desc';
        $result = ParserService::getAds($url);

        $this->assertIsArray($result);
        $this->assertCount(7, $result[0]);
    }
}
