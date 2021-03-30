<?php

declare(strict_types=1);

namespace Sujanstha2052\Router;

interface RouterInterface
{
    public function add(string $route, array $params) : void;

    public function dispatch(string $ulr): void;
}