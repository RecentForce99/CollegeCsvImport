<?php

namespace Nikitq\Api\DTO;

class CsvFileDTO
{
    private string $tmpPath;
    private string $name;
    private string $type;
    private int $size;
    private int $error;
    private string $path;
    private int $statusCode; //HTTP status codes
    private string $statusText;
    private ?CsvFilesContentDTO $records;

    public function __construct(
        string $tmpPath,
        string $name,
        string $type,
        int $size,
        int $error,
        string $path = '',
        int $statusCode = 200,
        string $statusText = '',
        CsvFilesContentDTO $records = null,
    ) {
        $this->tmpPath = $tmpPath;
        $this->name = $name;
        $this->type = $type;
        $this->size = $size;
        $this->error = $error;
        $this->path = $path;
        $this->statusCode = $statusCode;
        $this->statusText = $statusText;
        $this->records = $records;
    }

    public function setError(int $error): self
    {
        $this->error = $error;
        return $this;
    }

    public function setStatusCode(int $statusCode): self
    {
        $this->statusCode = $statusCode;
        return $this;
    }

    public function setStatusText(string $statusText): self
    {
        $this->statusText = $statusText;
        return $this;
    }

    public function setPath(string $path): self
    {
        $this->path = $path;
        return $this;
    }

    public function setRecords(?CsvFilesContentDTO $records): void
    {
        $this->records = $records;
    }

    public function getTmpPath(): string
    {
        return $this->tmpPath;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function getSize(): int
    {
        return $this->size;
    }

    public function getError(): int
    {
        return $this->error;
    }

    public function getPath(): string
    {
        return $this->path;
    }

    public function getStatusCode(): int
    {
        return $this->statusCode;
    }

    public function getStatusText(): string
    {
        return $this->statusText;
    }

    public function getRecords(): ?CsvFilesContentDTO
    {
        return $this->records;
    }
}