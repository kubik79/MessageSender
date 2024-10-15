<?php

declare(strict_types=1);

namespace Repository;

use Core\Database;
use PDO;

class AbstractRepository
{
    protected PDO $db;

    public function __construct()
    {
        $database = new Database();
        $this->db = $database->connect();
    }
}
