<?php

declare(strict_types=1);

namespace Repository;

use PDO;

class UsersRepository extends AbstractRepository
{
    public function findAll(): false|array
    {
        $sql = 'SELECT id FROM users';
        return $this->db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    public function addUser(string $number, string $name): void
    {
        $sql = 'INSERT INTO users (number, name) VALUES (:number, :name)';
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':number', $number);
        $stmt->bindValue(':name', $name);
        $stmt->execute();
    }
}
