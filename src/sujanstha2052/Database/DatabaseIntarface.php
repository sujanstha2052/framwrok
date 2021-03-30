<?php

declare(strict_types=1);
use PDO;
namespace Sujanstha2052\Database;

interface DatabaseInterface
{
    public function open(): PDO;

    public function close(): void;
}