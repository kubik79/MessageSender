#!/usr/bin/env php
<?php

declare(strict_types=1);

use Repository\MailingQueueRepository;

require_once __DIR__ . '/../Command/AbstractCommand.php';
require __DIR__ . '/../autoload.php';

class SendMailingQueue extends AbstractCommand
{
    private MailingQueueRepository $mailingQueueRepository;

    public function __construct()
    {
        parent::__construct();
        $this->mailingQueueRepository = new MailingQueueRepository();
    }

    public function sendPendingMessages(): void
    {
        try {
            $messages = $this->mailingQueueRepository->findAllUnsendMessage();

            if (empty($messages)) {
                echo "Нет неотправленных сообщений.\n";
                return;
            }

            foreach ($messages as $message) {
                $this->sendMessage(
                    $message['user_id'],
                    $message['title'],
                    $message['text'],
                );
                $this->mailingQueueRepository->markAsSent($message['id']);
            }
        } catch (PDOException $e) {
            echo "Ошибка при отправке сообщений: " . $e->getMessage() . "\n";
        }
    }

    private function sendMessage(int $userId, string $title, string $text): void
    {
        echo "Отправка сообщения пользователю с ID $userId [== $title == : $text]\n";
    }
}

if (php_sapi_name() === 'cli') {
    $queue = new SendMailingQueue();
    $queue->sendPendingMessages();
} else {
    echo "Этот скрипт можно запускать только из командной строки.\n";
    exit(1);
}
