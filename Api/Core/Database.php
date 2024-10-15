<?php

declare(strict_types=1);

namespace Core;

use PDO;

class Database
{
    const string HOST = 'postgresql';
    const string DB = 'postgre';
    const string USER = 'postgre';
    const string PASSWORD = 'postgre';

    public function __construct()
    {
        $this->connect();
    }

    public function connect(): PDO
    {
        $dsn = 'pgsql:host=' . self::HOST . ';port=5432;dbname=' . self::DB;

        return new PDO($dsn, self::USER, self::PASSWORD, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
    }
}
