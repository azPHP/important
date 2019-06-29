# important
Simple library showing how to use an inverse generator to act as a batch importer

## Configuration

`composer require `

## Usage

```php
<?php

$batcher = function (array $values)
{
    /** @var \PDO $myDb */
    $stmt = $myDb->query('INSERT blah blah');
    // maybe do some data transformation
    $stmt->execute($values);
};

$importer = \AzPHP\Important\Importer::createImporter(
    $batcher,
    100
);

/** @var iterable $someData */
foreach ($someData as $value) {
    $importer->send($value);
}

// finish any extra values not covered by a batch
$importer->send(null);
```