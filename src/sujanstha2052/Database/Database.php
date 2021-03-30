<?php

declare(strict_types=1);

namespace Sujanstha2052\Database;
use PDO;
use Sujanstha2052\Database\DatabaseInterface;
use Sujanstha2052\Database\Exception\DatabaseException;

class Database implements DatabaseInterface
{
    protected PDO $dbh;

    protected array $credentials;

    public function __construct(array $credentials)
    {
        $this->credentials = $credentials;
    }

    public function open(): PDO
    {
        try {
            $params = [
                PDO::ATTR_EMULATE_PREPARES => false,
                PDO::ATTR_PRESISTENT => true,
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
            ];


            $this->dbh = new PDO(
                $this->credentials['dsn'],
                $this->credentials['username'],
                $this->credentials['password'],
                $params,
            );
        } catch (PDOException $exception) {
            throw new DatabaseException($exception->getMessage(), (int)$exception->getCode());
        }
    }

    public function close(): void
    {
        $this->dbh = null;
    }
}