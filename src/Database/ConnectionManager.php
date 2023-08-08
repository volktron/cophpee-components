<?php declare(strict_types=1);

namespace Cophpee\Components\Database;

class ConnectionManager
{
    public array $connections = [];
    public ?Connection $defaultConnection;

    public function __construct(array $config = [])
    {
        foreach($config['connections'] as $connection) {
            $this->connections[$connection['name']] = new Connection($connection);
        }

        $this->defaultConnection = $config['default'] ?? $this->connections[0] ?? null;
    }

    public function init(string $connectionName): void
    {
        $this->connections[$connectionName]->init();
    }

    public function initAll(): void
    {
        foreach($this->connections as $connection) {
            $connection->close();
        }
    }

    public function close(string $connectionName): void
    {
        $this->connections[$connectionName]->close();
    }

    public function closeAll(): void
    {
        foreach($this->connections as $connection) {
            $connection->close();
        }
    }
}
