<?php

declare(strict_types=1);

namespace Core\Exception;

class ControllerNotFoundException extends \RuntimeException
{
    public function __construct(string $message = "Контроллер не найден.", int $code = 404)
    {
        parent::__construct($message, $code);
    }
}
