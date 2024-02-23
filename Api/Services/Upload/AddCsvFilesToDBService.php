<?php

namespace Nikitq\Api\Services\Upload;

use Nikitq\Api\DTO\CsvFileDTO;
use Nikitq\Api\Helpers\FileStatusManager;
use Nikitq\Api\Helpers\HttpStatusCodes;
use Nikitq\Api\Models\CsvFiles;
use Nikitq\Api\Models\CsvFilesContent;
use Nikitq\Database\Connection;

class AddCsvFilesToDBService
{
    private array $preparedFiles;
    private array $successFiles = [];
    private array $failedFiles = [];

    public function __construct(array $preparedFiles)
    {
        $this->preparedFiles = $preparedFiles;
    }

    public function uploadFiles(): void
    {
        $DB = Connection::getInstance()->getDB();
        foreach ($this->preparedFiles as $file) {
            if (!$this->checkFileExistence($file)) {
                continue;
            }

            $records = $this->getRecords($file);
            $preparedRecords = $this->getPreparedRecords($records);

            if (empty($preparedRecords)) {
                $this->setErrorForEmptyFile($file);
            }


        }

        $DB->beginTransaction();
        if ($fileId = $this->saveFile($file)) {
            if ($this->saveFileContent($preparedRecords, $file)) {
                $DB->commit();
            }
        } else {
            $DB->rollBack();
        }
    }
    private function saveFile(CsvFileDTO $file): ?int
    {
        return CsvFiles::add(
            $file->getName(),
            $file->getSize(),
            $file->getPath(),
            date('Y-m-d H:i:s'),
        );
    }

    private function saveFileContent(array $preparedRecords, CsvFileDTO $file): ?int
    {
        return CsvFilesContent::add(
            $file->getName(),
            $file->getSize(),
            $file->getPath(),
            date('Y-m-d H:i:s'),
        );
    }
}