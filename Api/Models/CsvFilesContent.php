<?php

namespace Nikitq\Api\Models;

use Nikitq\Api\DTO\CsvFileDTO;
use Nikitq\Api\DTO\CsvFilesContentDTO;
use Nikitq\Api\ValueObjects\CsvFilesContentValueObject;
use Nikitq\Database\Connection;

class CsvFilesContent
{
    private static string $tableName = 'csv_files_content';

    public static function add(string $email, string $name, int $quota, string $date, int $fileId): ?int
    {
        $DB = Connection::getInstance()->getDB();
        $tableName = static::$tableName;

        $request = $DB->prepare(
            "INSERT INTO `$tableName` (`email`, `name`, `quota`, `date`, `file_id`) VALUES (:email, :name, :quota, :date, :file_id)"
        );

        $request->bindParam(':email', $email);
        $request->bindParam(':name', $name);
        $request->bindParam(':quota', $quota);
        $request->bindParam(':date', $date);
        $request->bindParam(':file_id', $fileId);

        if ($request->execute()) {
            return $DB->lastInsertId();
        }

        return null;
    }

    public static function getListById(int $fileId): CsvFilesContentValueObject
    {
        $result = new CsvFilesContentValueObject();

        $DB = Connection::getInstance()->getDB();
        $tableName = static::$tableName;

        $request = $DB->prepare(
            "SELECT * FROM `$tableName` WHERE `file_id` = :file_id"
        );

        $request->bindParam(':file_id', $fileId);
        $request->execute();

        $files = $request->fetchAll($DB::FETCH_ASSOC);
        if (empty($files)) {
            return $result;
        }

        foreach ($files as $file) {
            $result->addRecord(
                new CsvFilesContentDTO(
                    $file['id'],
                    $file['email'],
                    $file['name'],
                    $file['quota'],
                    $file['date'],
                    $file['file_id'],
                )
            );
        }

        return $result;
    }
}