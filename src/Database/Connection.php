<?php declare(strict_types=1);

namespace Cophpee\Components\Database;

use PDO;

class Connection
{
    protected PDO $pdo;

    public function __construct(array $params) {
        $this->pdo = $this->getPdoFromParams($params);
    }

    protected function getPdoFromParams(array $params): ?PDO {
        return match($params['type']) {
            'mysql' => new PDO(
                'mysql:dbname='.$params['schema'].';host='.$params['host'].';port='.($params['port'] ?? 3306),
                $params['username'],
                $params['password']
            ),
            'postgres' => new PDO(
                'pgsql:dbname='.$params['schema'].';host='.$params['host'].';port='.($params['port'] ?? 5432).
                ';user='.$params['username'].
                ';password='.$params['password']
            ),
            'sqlite' => new PDO(
                'sqlite:'.($params['path'] ?? ':memory:')
            ),
            default => null
        };
    }

    public function prepare(string $query): Statement
    {
        return new Statement($this->pdo->prepare($query));
    }

    public function query(string $query, ?array $params = null): Statement
    {
        if(!$params) {
            return new Statement($this->pdo->query($query));
        }

        $pdoStatement = $this->pdo->prepare($query);
        $pdoStatement->execute($params);
        return new Statement($pdoStatement);
    }

    public function lastInsertId(): false|string
    {
        return $this->pdo->lastInsertId();
    }

    public function begin(): bool
    {
        return $this->pdo->beginTransaction();
    }

    public function end(): bool
    {
        return $this->pdo->commit();
    }
}
