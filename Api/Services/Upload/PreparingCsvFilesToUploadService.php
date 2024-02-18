<?php

namespace Nikitq\Api\Services\Upload;

use Nikitq\Api\Helpers\BytesConverterHelper;
use Nikitq\Api\Helpers\CsvFilesInfo;

class PreparingCsvFilesToUploadService
{
    public function getFiles(array $files): array
    {
        $result = [];
        foreach ($files as &$file) {
            $file = $this->getFileMap($file);
            $file['statusText'] = $this->getStatusText($file);
            $file['statusCode'] = $this->getStatusCode($file['statusText']);

            $result[] = $file;
        }

        return $result;
    }

    private function getStatusCode(?string $statusText): ?bool
    {
        if (empty($statusText)) {
            return null;
        }

        return CsvFilesInfo::STATUS_FAIL;
    }

    private function getStatusText(array $file): ?string
    {
        if ($file['type'] !== CsvFilesInfo::CSV_CODE) {
            return 'Неверное расширение файла. Должен быть csv';
        }
        if ($file['size'] > CsvFilesInfo::MAX_CSV_SIZE) {
            return 'Размер файла превышает ' . BytesConverterHelper::convert(CsvFilesInfo::MAX_CSV_SIZE);
        }

        return null;
    }

    private function getFileMap(object $file): array
    {
        return [
            'name' => $file->getClientFilename(),
            'type' => $file->getClientMediaType(),
            'size' => $file->getSize(),
            'error' => $file->getError(),
        ];
    }
}