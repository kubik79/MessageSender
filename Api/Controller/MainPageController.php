<?php

declare(strict_types=1);

namespace Controller;

class MainPageController
{
    public function __invoke(): void
    {
        include __DIR__ . '/../public/send.html';
    }
}
