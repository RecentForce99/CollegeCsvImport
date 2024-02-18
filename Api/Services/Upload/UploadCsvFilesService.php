<?php

namespace Nikitq\Api\Services\Upload;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class UploadCsvFilesService
{
    private const SEPARATOR = ';';
    private const UPLOADS_BASE_DIRECTORY = '/uploads/csv';

    private string $directory;
    private array $preparedFiles;

    public function __construct(array $preparedFiles) {
        $this->directory = $_SERVER['DOCUMENT_ROOT'] . self::UPLOADS_BASE_DIRECTORY;
        $this->preparedFiles = $preparedFiles;
    }

    public function uploadFiles(): void
    {
        if (is_dir($this->directory) || @mkdir($this->directory, 0777, true)) {
            $this->addRecords();
        };
    }

    public function addRecords(): void
    {
        foreach ($this->preparedFiles as $file) {
            $fileValues = $this->getValuesFromFile($file);
        }
    }

    private function addRecord(array $file): void
    {
        $extension = getValuesFromFile($path, PATHINFO_EXTENSION);

        if ($extension !== "csv") {
            throw new \Exception('Файл должен быть с расширением csv!');
        }

        $handle = fopen($path, 'r');

        if ($handle === false) {
            throw new \Exception('Файл не доступен');
        }

        while (($row = fgetcsv($handle, 200, ';')) !== false) {
            $result[] = $row;
        }

        fclose($handle);
    }

    private function addRecord(array $fileValues): array
    {

    }
}