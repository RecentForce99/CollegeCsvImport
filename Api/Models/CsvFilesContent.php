<?php

namespace Nikitq\Api\Models;

use DateTime;
use Nikitq\Database\Connection;

class CsvFilesContent
{
    private static string $tableName = 'csv_files_content';

    public static function add(string $email, string $name, int $quota, DateTime $date, int $fileId): ?int
    {
        $DB = Connection::getInstance()->getDB();
        $tableName = static::$tableName;

        $request = $DB->prepare(
            "INSERT INTO `$tableName` (`email`, `name`, `quota`, `date`, `file_id`) VALUES (:email, :name, :quota, :date, :file_id)"
        );

        $request->bindParam(':email', $originalName);
        $request->bindParam(':name', $size);
        $request->bindParam(':quota', $path);
        $request->bindParam(':date', $createdAt);
        $request->bindParam(':file_id', $createdAt);

        if ($request->execute()) {
            return $DB->lastInsertId();
        }

        return null;
    }
}