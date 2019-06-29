<?php


namespace AzPHP\Important;


use function foo\func;

class Importer
{
    public static function createImporter(
        callable $batchImport,
        $maxBatch
    )
    {
        $batch = [];
        while (true) {
            $value = yield;

            if (null === $value) {
                $batchImport($batch);
                break;
            }

            $batch[] = $value;
            if (count($batch) >= $maxBatch) {
                $batchImport($batch);
                $batch = [];
            }
        }
    }
}