<?php


namespace AzPHP\Important;


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
                if (!empty($batch)) {
                    $batchImport($batch);
                }
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