<?php

namespace Nikitq\Api\Services\Upload;

use Nikitq\Api\DTO\CsvFileDTO;
use Nikitq\Api\Helpers\BytesConverter;
use Nikitq\Api\Helpers\CsvFilesInfo;
use Nikitq\Api\Helpers\FileStatusManager;
use Nikitq\Api\Helpers\HttpStatusCodes;
use Slim\Http\UploadedFile;

class PreparingCsvFilesToUploadService extends AbstractPreparingFiles
{
    public function prepareFiles(): void
    {
        foreach ($this->files as &$file) {
            $file = $this->getFileMap($file);
            $statusText = $this->getStatusText($file);
            $statusCode = $this->setStatusCode($statusText);

            if ($file->getError() > 0 || $statusCode !== HttpStatusCodes::OK) {
                $this->failedFiles[] = FileStatusManager::getFileWithError(
                    HttpStatusCodes::BAD_REQUEST,
                    $statusText,
                    $file
                );
            } else {
                $this->preparedFiles[] = $file;
            }
        }
    }

    private function getFileMap(UploadedFile $file): CsvFileDTO
    {
        return new CsvFileDTO(
            $file->file,
            $file->getClientFilename(),
            $file->getClientMediaType(),
            $file->getSize(),
            $file->getError(),
        );
    }

    private function setStatusCode(string $statusText): int
    {
        if (empty($statusText)) {
            return HttpStatusCodes::OK;
        }

        return HttpStatusCodes::BAD_REQUEST;
    }

    private function getStatusText(CsvFileDTO $file): string
    {
        $statusText = '';
        if ($file->getError()) {
            $statusText = 'Произошла ошибка при передаче файла на сервер';
        } elseif ($file->getType() !== CsvFilesInfo::CODE) {
            $statusText = 'Неверное расширение файла. Должен быть csv';
        } elseif ($file->getSize() == 0) {
            $statusText = 'Файл - пустой';
        } elseif ($file->getSize() > CsvFilesInfo::MAX_SIZE) {
            $statusText = 'Размер файла превышает ' . BytesConverter::convert(CsvFilesInfo::MAX_SIZE);
        }

        return $statusText;
    }
}