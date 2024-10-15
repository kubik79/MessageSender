<?php

declare(strict_types=1);

namespace Core\Exception;

use Throwable;

class RouteNotFoundException extends \RuntimeException
{
    public function __construct(string $message = "Маршрут не найден.", int $code = 404)
    {
        parent::__construct($message, $code);
    }
}
