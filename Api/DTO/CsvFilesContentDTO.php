<?php

namespace Nikitq\Api\DTO;

class CsvFilesContentDTO
{
    private ?int $id;
    private string $email;
    private string $name;
    private int $quota;
    private string $date;
    private ?int $fileId;

    public function __construct(?int $id, string $email, string $name, int $quota, string $date, ?int $fileId = null)
    {
        $this->id = $id;
        $this->email = $email;
        $this->name = $name;
        $this->quota = $quota;
        $this->date = $date;
        $this->fileId = $fileId;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getQuota(): int
    {
        return $this->quota;
    }

    public function setQuota(int $quota): void
    {
        $this->quota = $quota;
    }

    public function getDate(): string
    {
        return $this->date;
    }

    public function setDate(string $date): void
    {
        $this->date = $date;
    }

    public function getFileId(): ?int
    {
        return $this->fileId;
    }

    public function setFileId(?int $fileId): void
    {
        $this->fileId = $fileId;
    }
}