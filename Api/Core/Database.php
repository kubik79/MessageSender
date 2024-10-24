<?php

declare(strict_types=1);

namespace Core;

use PDO;
use PDOException;

class Database
{
    private static ?PDO $instance = null;

    const string HOST = 'postgresql';
    const string DB = 'postgre';
    const string USER = 'postgre';
    const string PASSWORD = 'postgre';

    /**
     * @throws \Exception
     */
    public function __construct() {}

    private function __clone() {}

    /**
     * @throws \Exception
     */
    public static function connect(): PDO
    {
        if (self::$instance === null) {
            try {
                $dsn = 'pgsql:host=' . self::HOST . ';port=5432;dbname=' . self::DB;

                self::$instance = new PDO($dsn, self::USER, self::PASSWORD);
                self::$instance->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                self::$instance->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            } catch (PDOException $e) {
                throw new \Exception('Database connection error: ' . $e->getMessage());
            }
        }

        return self::$instance;
    }
}
