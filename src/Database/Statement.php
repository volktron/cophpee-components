<?php declare(strict_types=1);

namespace Cophpee\Components\Database;

use PDO;

class Statement
{
    protected int $defaultFetchMode = PDO::FETCH_ASSOC;

    public function __construct(
        protected \PDOStatement $statement
    ) {
    }

    public function fetchAll(): false|array
    {
        return $this->statement->fetchAll($this->defaultFetchMode);
    }

    public function fetchRow() {
        return $this->statement->fetch($this->defaultFetchMode);
    }
}