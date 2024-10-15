<?php

declare(strict_types=1);

use Core\Database;

require __DIR__ . '/../autoload.php';

class AbstractCommand
{
    protected PDO $db;

    public function __construct()
    {
        $database = new Database();
        $this->db = $database->connect();
    }
}
