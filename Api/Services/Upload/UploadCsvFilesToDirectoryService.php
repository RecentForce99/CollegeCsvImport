<?php

namespace Nikitq\Api\Services\Upload;

use Nikitq\Api\DTO\CsvFileDTO;
use Nikitq\Api\Helpers\CsvFilesInfo;
use Nikitq\Api\Helpers\FileStatusManager;
use Nikitq\Api\Helpers\HttpStatusCodes;

class UploadCsvFilesToDirectoryService
{
    private string $directory;
    private array $files;
    private array $uploadedFiles = [];
    private array $failedFiles = [];

    public function __construct(array $files)
    {
        $this->directory = $_SERVER['DOCUMENT_ROOT'] . CsvFilesInfo::UPLOADS_BASE_DIRECTORY;
        $this->files = $files;
    }

    public function uploadFiles(): void
    {
        if (is_dir($this->directory) || @mkdir($this->directory, 0777, true)) {
            foreach ($this->files as &$file) {
                $filePath = $this->getGeneratedPathRecursive($file);
                $saveFileStatus = $this->saveFile($file, $filePath);

                if ($saveFileStatus) {
                    $file->setPath($filePath);
                    $this->uploadedFiles[] = $file;
                } else {
                    $file = FileStatusManager::getFileWithStatus(
                        HttpStatusCodes::INTERNAL_SERVER_ERROR,
                        'Произошла внутрення ошибка сервера во время сохранения файла на диск',
                        $file
                    );
                    $this->failedFiles[] = $file;
                }
            }
        };
    }

    public function getUploadedFiles(): array
    {
        return $this->uploadedFiles;
    }

    public function getFailedFiles(): array
    {
        return $this->failedFiles;
    }

    private function saveFile(CsvFileDTO $file, string $filePath): bool
    {
        $fileTmpPath = $file->getTmpPath();
        $uploadedFile = move_uploaded_file($fileTmpPath, $_SERVER['DOCUMENT_ROOT'] . $filePath);

        if (!$uploadedFile) {
            return false;
        }

        return true;
    }

    private function getGeneratedPathRecursive(CsvFileDTO $file, string $fileName = ''): string
    {
        if (empty($fileName)) {
            $fileName = md5($file->getName());
        }

        $filePath = $this->directory . '/' . $fileName . CsvFilesInfo::EXTENSION;
        if (file_exists($filePath)) {
            return $this->getGeneratedPathRecursive($file, md5($fileName . date('d.m.Y H:i:s')));
        }

        return CsvFilesInfo::UPLOADS_BASE_DIRECTORY . '/' . $fileName . CsvFilesInfo::EXTENSION;
    }
}