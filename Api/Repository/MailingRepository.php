<?php

declare(strict_types=1);

namespace Repository;

class MailingRepository extends AbstractRepository
{
    public function find(int $id): mixed
    {
        $mailingExistsQuery = 'SELECT id FROM mailings WHERE id = :mailing_id';
        $stmt = $this->db->prepare($mailingExistsQuery);
        $stmt->execute([':mailing_id' => $id]);

        return $stmt->fetch();
    }
}
