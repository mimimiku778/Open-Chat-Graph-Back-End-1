<?php

declare(strict_types=1);

namespace App\Services\OpenChat\Crawler;

use App\Services\Crawler\CrawlerFactory;
use App\Config\OpenChatCrawlerConfig;
use Shadow\Kernel\Validator;

class OpenChatApiRankingDownloaderProcess
{
    private CrawlerFactory $crawlerFactory;

    function __construct(CrawlerFactory $crawlerFactory)
    {
        $this->crawlerFactory = $crawlerFactory;
    }

    /**
     * @return array|false `[string|false $ct, int $count]`
     */
    function fetchOpenChatApiRankingProcess(string $category, string $ct, \Closure $callback): array|false
    {
        $url = OpenChatCrawlerConfig::generateOpneChatApiRankigDataUrl($category, $ct);
        $ua = OpenChatCrawlerConfig::USER_AGENT;

        $response = $this->crawlerFactory->createCrawler($url, $ua, getCrawler: false);
        if (!$response) {
            return false;
        }

        $apiData = json_decode($response, true);
        if (!is_array($apiData)) {
            return false;
        }

        $squares = $apiData['squaresByCategory'][0]['squares'] ?? false;
        if (!is_array($squares)) {
            return false;
        }

        $count = count($squares);
        if ($count < 1) {
            return false;
        }

        $callback($apiData);

        $responseCt = Validator::str($apiData['continuationTokenMap'][$category] ?? false);

        return [$responseCt, $count];
    }
}
