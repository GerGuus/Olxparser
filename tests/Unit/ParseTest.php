<?php

namespace Tests\Unit;

use App\Services\ParserService;
use PHPUnit\Framework\TestCase;

class ParseTest extends TestCase
{
    public function testGetAdInformation()
    {
        $url = 'https://www.olx.ua/d/uk/obyavlenie/1k-kvartira-v-tsentre-svoya-IDQ3Ixc.html';
        $result = ParserService::getAdInformation($url);

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
