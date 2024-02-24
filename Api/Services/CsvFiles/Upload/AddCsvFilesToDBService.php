<?php

namespace Nikitq\Api\Services\CsvFiles\Upload;

use Nikitq\Api\DTO\CsvFileUploadDTO;
use Nikitq\Api\Helpers\FileStatusManager;
use Nikitq\Api\Helpers\HttpStatusCodes;
use Nikitq\Api\Models\CsvFiles;
use Nikitq\Api\Models\CsvFilesContent;
use Nikitq\Api\ValueObjects\CsvFilesContentValueObject;
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
        global $DB;
        $DB = Connection::getInstance()->getDB();
        $DB->beginTransaction();

        foreach ($this->preparedFiles as &$file) {
            if ($fileId = $this->saveFile($file)) {
                if ($this->saveFileContent($file->getRecords(), $fileId)) {
                    $file->setRecords(null); //In order free up the memory
                    $this->addSuccessFile($file);
                } else {
                    $this->addFailedFile($file);
                }
            } else {
                $this->addFailedFile($file);
            }
        }

        if (empty($this->failedFiles)) {
            $DB->commit();
        } else {
            $DB->rollBack();
        }
    }

    public function getSuccessFiles(): array
    {
        return $this->successFiles;
    }

    public function getFailedFiles(): array
    {
        return $this->failedFiles;
    }

    private function saveFile(CsvFileUploadDTO $file): ?int
    {
        return CsvFiles::add(
            $file->getName(),
            $file->getSize(),
            $file->getPath(),
            date('Y-m-d H:i:s'),
        );
    }

    private function saveFileContent(CsvFilesContentValueObject $records, int $fileId): bool
    {
        foreach ($records->getRecords() as $record) {
            $resultAdd = CsvFilesContent::add(
                $record->getEmail(),
                $record->getName(),
                $record->getQuota(),
                date('Y-m-d H:i:s'),
                $fileId,
            );

            if ($resultAdd) {
                $result = true;
            }
        }

        return $result;
    }

    private function addSuccessFile(CsvFileUploadDTO $file): void
    {
        $this->successFiles[] = FileStatusManager::getFileWithStatus(
            HttpStatusCodes::OK,
            'Файл успешно загружен',
            $file
        );
    }

    private function addFailedFile(CsvFileUploadDTO $file): void
    {
        $this->failedFiles[] = FileStatusManager::getFileWithError(
            HttpStatusCodes::INTERNAL_SERVER_ERROR,
            'При сохранении файла в таблицу произошла ошибка',
            $file
        );
    }
}