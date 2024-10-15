#!/usr/bin/env php
<?php

declare(strict_types=1);

use Repository\MailingQueueRepository;
use Repository\MailingRepository;
use Repository\UsersRepository;

require_once __DIR__ . '/../Command/AbstractCommand.php';
require __DIR__ . '/../autoload.php';

class CreateMailingQueue extends AbstractCommand
{
    private MailingRepository $mailingRepository;
    private MailingQueueRepository $mailingQueueRepository;
    private UsersRepository $usersRepository;

    public function __construct()
    {
        parent::__construct();
        $this->mailingRepository = new MailingRepository();
        $this->mailingQueueRepository = new MailingQueueRepository();
        $this->usersRepository = new UsersRepository();
    }

    public function addToQueue(int $mailingId): void
    {
        try {
            $mailing = $this->mailingRepository->find($mailingId);
            if (!$mailing) {
                echo "Рассылка с ID $mailingId не найдена.\n";
                exit(1);
            }

            $users = $this->usersRepository->findAll();
            if (empty($users)) {
                echo "Нет пользователей для добавления в очередь.\n";
                exit(1);
            }

            $this->mailingQueueRepository->addMailingQueue($mailingId, $users);
        } catch (PDOException $e) {
            echo "Ошибка при добавлении в очередь: " . $e->getMessage() . "\n";
        }
    }
}

if (php_sapi_name() === 'cli') {
    if ($argc < 2) {
        echo "Использование: php Command/CreateMailingQueue.php <mailing_id>\n";
        exit(1);
    }

    $mailingId = (int)$argv[1];
    if ($mailingId <= 0) {
        echo "Укажите корректный ID рассылки.\n";
        exit(1);
    }

    $queue = new CreateMailingQueue();
    $queue->addToQueue($mailingId);
} else {
    echo "Этот скрипт можно запускать только из командной строки.\n";
    exit(1);
}
