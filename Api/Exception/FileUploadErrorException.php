<?php

declare(strict_types=1);

namespace Exception;

class FileUploadErrorException extends \RuntimeException
{
    public function __construct(string $message = "Ошибка загрузки файла.", int $code = 422)
    {
        parent::__construct($message, $code);
    }
}
