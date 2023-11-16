<?php

declare(strict_types=1);

namespace App\Controllers\Api;

use App\Models\current_ranking;
use App\Services\OpenChat\Crawler\OpenChatApiRankingDownloader;
use App\Config\AppConfig;

class TestApiController
{
    private array $data;

    function index(OpenChatApiRankingDownloader $api)
    {
        echo 'start';
        fastcgi_finish_request();

        foreach (AppConfig::OPEN_CHAT_CATEGORY as $c) {
            $this->data = [];

            $api->fetchOpenChatApiRanking((string)$c, function ($apiData) {
                $squares = $apiData['squaresByCategory'][0]['squares'];
                array_push($this->data, ...array_map(fn ($el) => $el['square']['emid'], $squares));
            });

            $cr = new current_ranking;
            $diff = [];

            if ($cr->find("SELECT * FROM current_ranking WHERE category = {$c}")) {
                $recentData = unserialize($cr->data);
                $diff = array_filter($this->data, fn ($emid) => !in_array($emid, $recentData));
            }

            if ($diff) {
                $cr->insert('ranking_history');
            }

            $cr->category = $c;
            $cr->data = serialize($this->data);
            $cr->time = date('Y-m-d H:i:s');
            $cr->insertUpdate();
        }
    }
}
