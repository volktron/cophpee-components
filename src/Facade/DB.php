<?php declare(strict_types=1);

namespace Cophpee\Components\Facade;

use Cophpee\Components\Database\Connection;
use Cophpee\Components\Database\ConnectionManager;
use Cophpee\Components\Database\Statement;

class DB
{
    static ConnectionManager $connectionManager;

    public static function init($config): void
    {
        self::$connectionManager = new ConnectionManager($config);
    }

    public static function connection(?string $name = null, bool $setDefault = false): Connection
    {
        if($name && $setDefault) {
            self::$connectionManager->setDefault($name);
            return self::$connectionManager->defaultConnection;
        }

        if($name) {
            return self::$connectionManager->connections[$name];
        }

        return self::$connectionManager->defaultConnection;
    }

    public static function query(string $query, ?array $params = null): Statement
    {
        return self::$connectionManager->defaultConnection->query($query, $params);
    }

    public static function lastInsertId(): false|string
    {
        return self::$connectionManager->defaultConnection->lastInsertId();
    }

    public static function begin(): bool
    {
        return self::$connectionManager->defaultConnection->begin();
    }

    public static function end(): bool
    {
        return self::$connectionManager->defaultConnection->end();
    }
}
