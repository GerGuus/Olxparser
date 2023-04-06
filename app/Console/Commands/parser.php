<?php

namespace App\Console\Commands;

use App\Models\Url;
use App\Services\BotService;
use App\Services\ParserService;
use Illuminate\Console\Command;

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
        $urlList = Url::where('user_id', 1)->get();

        foreach ($urlList as $url) {
            if ($url->deleted_at == null) {
                $ads = ParserService::getAds($url);

                foreach ($ads as $ad) {
                    $message = $ad['url'] .
                        "\n" . $ad['id'] .
                        "\n" . $ad['title'] .
                        "\n" . $ad['description'] .
                        "\n" . $ad['time'] .
                        "\n" . $ad['person'];

                    BotService::sendPhoto($ad['photo']);
                    BotService::sendMessage($message);
                }
            }
        }
    }
}
