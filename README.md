## Подготовка сервиса

Создать `.env` из `env.example`.

Собираем контейнеры:

```bash
docker compose build
docker compose up -d
```

В папке `/migrations` берем SQL миграцию и создаем бд и таблицы.


## Работа с сервисом

Загрузить файл со списком пользователей можно по адресу `http://localhost:8089/main`

В таблице `mailings` нужно создать рассылку.

### Создать очередь рассылки:

```bash
docker exec -it wahelp-test-php php Command/CreateMailingQueue.php 1
```

1 - это id созданной рассылки. Заполнится таблица `mailing_queue`.

### Отправить все сообщения из очереди

```bash
docker exec -it wahelp-test-php php Command/SendMailingQueue.php
```
