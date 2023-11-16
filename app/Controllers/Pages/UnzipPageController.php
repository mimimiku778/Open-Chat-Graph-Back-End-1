<?php

declare(strict_types=1);

namespace App\Controllers\Pages;

class UnzipPageController
{
    private function unzip()
    {
        $zipFile = __DIR__ . '/../../../storage/img_backup/oc-img/2023-11-16.zip';
        $extractTo =  __DIR__ . '/../../../public/oc-img/';

        // ディレクトリを解凍する
        $unzipDirectory = function ($zipFile, $extractTo) {
            $zip = new \ZipArchive();

            $res = $zip->open($zipFile);

            if ($res === true) {
                $zip->extractTo($extractTo);
                $zip->close();
                return true;
            } else {
                return false;
            }
        };


        $result = $unzipDirectory($zipFile, $extractTo);

        if ($result) {
            echo 'ディレクトリの解凍が成功しました。';
        } else {
            echo 'ディレクトリの解凍に失敗しました。';
        }
    }
}
