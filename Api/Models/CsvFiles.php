<?php

namespace Nikitq\Api\Models;

use Nikitq\Api\DTO\CsvFileDTO;
use Nikitq\Api\ValueObjects\CsvFilesValueObject;
use Nikitq\Database\Connection;

class CsvFiles
{
    private static string $tableName = 'csv_files';

    public static function add(string $originalName, int $size, string $path, string $createdAt): ?int
    {
        $DB = Connection::getInstance()->getDB();
        $tableName = static::$tableName;

        $request = $DB->prepare(
            "INSERT INTO `$tableName` (`original_name`, `size`, `path`, `created_at`) VALUES (:original_name, :size, :path, :created_at)"
        );

        $request->bindParam(':original_name', $originalName);
        $request->bindParam(':size', $size);
        $request->bindParam(':path', $path);
        $request->bindParam(':created_at', $createdAt);

        if ($request->execute()) {
            return $DB->lastInsertId();
        }

        return null;
    }

    public static function getFullList(): CsvFilesValueObject
    {
        $result = new CsvFilesValueObject();

        $DB = Connection::getInstance()->getDB();
        $tableName = static::$tableName;

        $request = $DB->query(
            "SELECT * FROM `$tableName`",
        );

        $files = $request->fetchAll($DB::FETCH_ASSOC);
        if (empty($files)) {
            return $result;
        }

        foreach ($files as $file) {
            $result->addFile(
                new CsvFileDTO(
                    $file['id'],
                    $file['original_name'],
                    $file['size'],
                    $file['path'],
                    $file['created_at'],
                )
            );
        }

        return $result;
    }
}