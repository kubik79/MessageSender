<?php

declare(strict_types=1);

namespace Exception;

class FileNotFoundException extends \RuntimeException
{
    public function __construct(string $message = "Файл не найден.", int $code = 404)
    {
        parent::__construct($message, $code);
    }
}
