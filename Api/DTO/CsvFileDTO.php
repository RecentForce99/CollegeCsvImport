<?php

namespace Nikitq\Api\DTO;

use Nikitq\Api\ValueObjects\CsvFilesContentValueObject;

class CsvFileDTO
{
    private int $id;

    private string $originalName;
    private int $size;
    private string $path;
    private string $createdAt;

    public function __construct(int $id, string $originalName, int $size, string $path, string $createdAt)
    {
        $this->id = $id;
        $this->originalName = $originalName;
        $this->size = $size;
        $this->path = $path;
        $this->createdAt = $createdAt;
    }


    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getOriginalName(): string
    {
        return $this->originalName;
    }

    public function setOriginalName(string $originalName): void
    {
        $this->originalName = $originalName;
    }

    public function getSize(): int
    {
        return $this->size;
    }

    public function setSize(int $size): void
    {
        $this->size = $size;
    }

    public function getPath(): string
    {
        return $this->path;
    }

    public function setPath(string $path): void
    {
        $this->path = $path;
    }

    public function getCreatedAt(): string
    {
        return $this->createdAt;
    }

    public function setCreatedAt(string $createdAt): void
    {
        $this->createdAt = $createdAt;
    }
}