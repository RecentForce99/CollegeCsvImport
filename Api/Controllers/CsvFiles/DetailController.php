<?php

namespace Nikitq\Api\Controllers\CsvFiles;

use Nikitq\Api\DTO\CsvFileDTO;
use Nikitq\Api\Models\CsvFiles;
use Nikitq\Api\Models\CsvFilesContent;

class DetailController
{
    public function getFiles(int $fileId): array
    {
        $files = [];
        $csvFilesObj = CsvFilesContent::getListById($fileId);
        foreach ($csvFilesObj->getRecords() as &$file) {
            $files[] = $file;
        }

        return $files;
    }
}