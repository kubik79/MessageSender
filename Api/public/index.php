<?php

declare(strict_types=1);

require __DIR__ . '/../autoload.php';

use Core\Router;

try {
    $router = new Router();
} catch (Throwable $exception) {
    http_response_code($exception->getCode());
    print $exception->getMessage();
}
