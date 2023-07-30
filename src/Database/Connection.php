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
                // mysql:host=<host>;port=<port>;dbname=<schema>;user=<username>;password=<password>
                'mysql:host='.$params['host'].';port='.($params['port'] ?? 3306).'dbname='.$params['schema'],
                $params['username'],
                $params['password']
            ),
            'postgres' => new PDO(
                // pgsql:host=<host>;port=<port>;dbname=<schema>;user=<username>;password=<password>
                'pgsql:host='.$params['host'].';port='.($params['port'] ?? 5432).';dbname='.$params['schema'].
                ';user='.$params['username'].
                ';password='.$params['password']
            ),
            'sqlite' => new PDO(
                // sqlite:<path>
                'sqlite:'.($params['path'] ?? ':memory:')
            ),
            'sqlsrv' => new PDO(
                // sqlsrv:Server=<host>,<port>;Database=<schema>
                'sqlsrv:Server='.$params['host'].','.($params['port'] ?? 1521).';Database='.$params['schema'],
                $params['username'],
                $params['password']
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
