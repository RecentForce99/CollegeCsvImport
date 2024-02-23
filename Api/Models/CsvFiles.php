<?php

namespace Nikitq\Api\Models;

use Nikitq\Database\Connection;

class CsvFiles
{
    private static string $tableName = 'csv_files';

    public static function add($originalName, $size, $path, $createdAt): ?int
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
}