<?php

declare(strict_types=1);

namespace Repository;

use Core\Database;
use PDO;

class AbstractRepository
{
    protected PDO $db;

    /**
     * @throws \Exception
     */
    public function __construct()
    {
        $this->db = Database::connect();
    }
}
