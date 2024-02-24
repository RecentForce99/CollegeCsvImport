<?php

namespace Nikitq\Api\ValueObjects;


use Nikitq\Api\DTO\CsvFileDTO;

class CsvFilesValueObject
{
    private array $files = [];

    public function addFile(CsvFileDTO $csvFileDTO)
    {
        $this->files[] = $csvFileDTO;
    }

    public function getFiles(): array
    {
        return $this->files;
    }
}