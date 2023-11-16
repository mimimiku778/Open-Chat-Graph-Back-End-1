<?php

declare(strict_types=1);

namespace App\Services\OpenChat\Crawler;

class OpenChatApiRankingDownloader
{
    private OpenChatApiRankingDownloaderProcess $openChatApiRankingDownloaderProcess;

    function __construct(OpenChatApiRankingDownloaderProcess $openChatApiRankingDownloaderProcess)
    {
        $this->openChatApiRankingDownloaderProcess = $openChatApiRankingDownloaderProcess;
    }

    /**
     * @throws \RuntimeException
     */
    function fetchOpenChatApiRanking(string $category, \Closure $callback): int
    {
        $resultCount = 0;

        $ct = '0';
        while ($ct !== false) {
            $response = $this->openChatApiRankingDownloaderProcess
                ->fetchOpenChatApiRankingProcess($category, $ct, $callback);

            if ($response === false) {
                break;
            }

            [$ct, $count] = $response;
            $resultCount += (int)$count;
        }

        return $resultCount;
    }
}
