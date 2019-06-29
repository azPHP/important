<?php

namespace Test\AzPHP\Important;

use AzPHP\Important\Importer;
use PHPUnit\Framework\TestCase;

class ImporterTest extends TestCase
{
    public function testCreateImporter()
    {
        $importer = Importer::createImporter(function() {}, 10);
        $this->assertInstanceOf(\Generator::class, $importer);
    }

    public function testImporterRunsBatches()
    {
        $batches = [];
        $batcher = function (array $values) use (&$batches) {
            $batches[] = $values;
        };

        $importer = Importer::createImporter($batcher, 5);

        for($i = 0;$i < 12;$i++) {
            $importer->send($i);
        }

        $this->assertCount(2, $batches);
    }

    public function testImporterFinishesOnNull()
    {
        $batches = [];
        $batcher = function (array $values) use (&$batches) {
            $batches[] = $values;
        };

        $importer = Importer::createImporter($batcher, 5);

        for($i = 0;$i < 12;$i++) {
            $importer->send($i);
        }

        $importer->send(null);
        $this->assertCount(3, $batches);
    }
}
