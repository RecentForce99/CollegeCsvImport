<?php

namespace Nikitq\Database;

use PDO;

class Connection
{
    private static ?Connection $instance = null;
    private ?PDO $pdo = null;

    private function construct()
    {
    }

    public static function getInstance(): self
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    public function getDB(): PDO
    {
        if ($this->pdo === null) {
            $this->pdo = new PDO(
                "{$_ENV['DB_CONNECTION']}:host={$_ENV['DB_HOST']};dbname={$_ENV['DB_DATABASE']}",
                $_ENV['DB_USERNAME'],
                $_ENV['DB_PASSWORD']
            );
        }

        return $this->pdo;
    }
}