<?php

namespace Nikitq\Api\Helpers;

use Nikitq\Api\DTO\CsvFileUploadDTO;

class FileStatusManager
{
    public static function getFileWithStatus(int $statusCode, string $statusText, CsvFileUploadDTO $file): CsvFileUploadDTO
    {
        $file->setError(0);
        $file->setStatusCode($statusCode);
        $file->setStatusText($statusText);

        return $file;
    }

    public static function getFileWithError(int $statusCode, string $statusText, CsvFileUploadDTO $file): CsvFileUploadDTO
    {
        $file->setError(1);
        $file->setStatusCode($statusCode);
        $file->setStatusText($statusText);

        return $file;
    }
}