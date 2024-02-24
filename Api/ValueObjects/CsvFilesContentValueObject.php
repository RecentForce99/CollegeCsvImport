<?php

namespace Nikitq\Api\ValueObjects;

use Nikitq\Api\DTO\CsvFilesContentDTO;

class CsvFilesContentValueObject
{
    private array $records = [];

    public function addRecord(CsvFilesContentDTO $csvFilesContent)
    {
        $this->records[] = $csvFilesContent;
    }

    public function getRecords(): array
    {
        return $this->records;
    }
}