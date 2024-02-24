<?php

namespace Nikitq\Api\Controllers\CsvFiles;

use Nikitq\Api\DTO\CsvFileDTO;
use Nikitq\Api\Models\CsvFiles;

class ListController
{
    public function getFiles(): array
    {
        $files = [];
        $csvFilesObj = CsvFiles::getFullList();
        foreach ($csvFilesObj->getFiles() as &$file) {
            $file->link = $this->getLink($file);
            $files[] = $file;
        }

        return $files;
    }

    private function getLink(CsvFileDTO $file): string
    {
        return "/csv/list/{$file->getId()}/";
    }
}