<?php

namespace Nikitq\Api\Helpers;

use Nikitq\Api\DTO\CsvFileDTO;

class FileStatusManager
{
    public static function getFileWithStatus(int $statusCode, string $statusText, CsvFileDTO $file): CsvFileDTO
    {
        $file->setError(0);
        $file->setStatusCode($statusCode);
        $file->setStatusText($statusText);

        return $file;
    }

    public static function getFileWithError(int $statusCode, string $statusText, CsvFileDTO $file): CsvFileDTO
    {
        $file->setError(1);
        $file->setStatusCode($statusCode);
        $file->setStatusText($statusText);

        return $file;
    }
}