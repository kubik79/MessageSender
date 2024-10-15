<?php

declare(strict_types=1);

namespace Repository;

use PDO;

class MailingQueueRepository extends AbstractRepository
{
    public function addMailingQueue(int $mailingId, array $users): void
    {
        $insertQuery = 'INSERT INTO mailing_queue (user_id, mailing_id, sent) VALUES (:user_id, :mailing_id, FALSE)';
        $stmt = $this->db->prepare($insertQuery);

        foreach ($users as $user) {
            $stmt->execute([
                ':user_id' => $user['id'],
                ':mailing_id' => $mailingId,
            ]);

            echo "Пользователь с ID " . $user['id'] . " добавлен в очередь рассылки.\n";
        }
    }

    public function findAllUnsendMessage(): false|array
    {
        $sql = '
            SELECT mq.id, mq.user_id, m.title, m.text
            FROM mailing_queue mq
            LEFT OUTER JOIN public.mailings m on m.id = mq.mailing_id
            WHERE
                sent = FALSE
        ';
        $stmt = $this->db->query($sql);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function markAsSent(int $queueId): void
    {
        $updateQuery = 'UPDATE mailing_queue SET sent = TRUE, sent_at = NOW() WHERE id = :queue_id';
        $stmt = $this->db->prepare($updateQuery);
        $stmt->execute([':queue_id' => $queueId]);

        echo "Сообщение с ID $queueId помечено как отправленное.\n";
    }
}
