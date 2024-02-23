<?php

namespace Nikitq\Api\Services\Upload;

abstract class AbstractPreparingFiles
{
    protected array $preparedFiles = [];
    protected array $failedFiles = [];

    protected array $files;

    public function __construct(array $files)
    {
        $this->files = $files;
    }

    abstract public function prepareFiles(): void;

    public function getPreparedFiles(): array
    {
        return $this->preparedFiles;
    }

    public function getFailedFiles(): array
    {
        return $this->failedFiles;
    }
}