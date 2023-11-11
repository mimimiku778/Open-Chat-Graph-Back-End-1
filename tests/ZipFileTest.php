<?php

use PHPUnit\Framework\TestCase;

class ZipFileTest extends TestCase
{
    function test()
    {
        $zipFile = new \PhpZip\ZipFile();
        try {
            $zipFile
                ->addDir(__DIR__, 'ziptest') // add files from the directory
                ->saveAsFile('test.zip') // save the archive to a file
                ->close(); // close archive
        } catch (\PhpZip\Exception\ZipException $e) {
            // handle exception
        } finally {
            $zipFile->close();
        }
    }
}
