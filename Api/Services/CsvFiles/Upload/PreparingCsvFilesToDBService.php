<?php

namespace Nikitq\Api\Services\CsvFiles\Upload;

use Nikitq\Api\DTO\CsvFileUploadDTO;
use Nikitq\Api\DTO\CsvFilesContentDTO;
use Nikitq\Api\Helpers\FileStatusManager;
use Nikitq\Api\Helpers\HttpStatusCodes;
use Nikitq\Api\ValueObjects\CsvFilesContentValueObject;

class PreparingCsvFilesToDBService extends AbstractPreparingFiles
{
    private const SEPARATOR = ',';

    public function prepareFiles(): void
    {
        foreach ($this->files as $file) {
            if (!$this->checkFileExistence($file)) {
                continue;
            }

            $records = $this->getRecords($file);
            $preparedRecords = $this->getPreparedRecords($records);

            if (empty($preparedRecords->getRecords())) {
                $this->setErrorForEmptyFile($file);
            }

            $file->setRecords($preparedRecords);
            $this->preparedFiles[] = $file;
        }
    }

    private function checkFileExistence(CsvFileUploadDTO $file): bool
    {
        if (!file_exists($_SERVER['DOCUMENT_ROOT'] . $file->getPath())) {
            $file = FileStatusManager::getFileWithError(
                HttpStatusCodes::INTERNAL_SERVER_ERROR,
                'Произошла ошибка во время чтения файла',
                $file
            );
            $this->failedFiles[] = $file;

            return false;
        }

        return true;
    }

    private function getRecords(CsvFileUploadDTO $file): array
    {
        $handle = fopen($_SERVER['DOCUMENT_ROOT'] . $file->getPath(), 'r');

        $records = [];
        while (($record = fgetcsv($handle, 200, self::SEPARATOR)) !== false) {
            $records[] = $record;
        }

        fclose($handle);

        return $records;
    }

    private function getPreparedRecords(array $records): CsvFilesContentValueObject
    {
        $headers = $records[0];
        unset($records[0]);

        $preparedRowsObj = new CsvFilesContentValueObject();
        foreach ($records as &$record) {
            $record = array_combine($headers, $record);
            if (!$this->areEmptyFields($record)) {
                continue;
            }

            $recordMap = new CsvFilesContentDTO(
                null,
                $record['Email'],
                $record['Name'],
                $record['Quota'],
                $record['StartDate'],
                null,
            );

            $preparedRowsObj->addRecord($recordMap);
        }

        return $preparedRowsObj;
    }

    private function areEmptyFields(?array $record): bool
    {
        if (
            empty($record) ||
            empty($record['Email']) ||
            empty($record['Name']) ||
            empty($record['Quota']) ||
            empty($record['StartDate'])
        ) {
            return false;
        }

        return true;
    }

    private function setErrorForEmptyFile(CsvFileUploadDTO $file): void
    {
        $this->failedFiles[] = FileStatusManager::getFileWithError(
            HttpStatusCodes::BAD_REQUEST,
            'Неверная структура файла',
            $file
        );
    }
}