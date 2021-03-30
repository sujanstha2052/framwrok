<?php

declare(strict_types=1);

namespace Sujanstha2052\Database;
use PDOException;

class DatabaseException extends PDOException
{
    protected $message;

    protected $code;

    public function __construct($message = null, $code = null)
    {
        $this->message = $message;
        $this->code = $code;
    }
}