<?php declare(strict_types=1);

namespace Cophpee\Tests\Database;

use Cophpee\Components\Database\Connection;
use PHPUnit\Framework\TestCase;

class MySqlTest extends TestCase
{
    protected Connection $connection;

    public function setUp(): void
    {
        parent::setUp();
        $this->connection = new Connection([
            'type' => 'mysql',
            'host' => 'localhost',
            'schema' => 'information_schema',
            'username' => 'root',
            'password' => 'root'
        ]);
    }

    public function testConnection() {
        $result = $this->connection->query('SELECT 1 as testColumn')->fetchAll();
        $this->assertCount(1, $result);
    }

    public function testSuccessfulTransaction() {
        $number = 12345;

        $this->connection->begin();
        $resultA = $this->connection->query('SELECT :number as testColumn', ['number' => $number])->fetchRow();
        $resultB = $this->connection->query('SELECT :number as testColumn', ['number' => $number])->fetchRow();
        $this->connection->end();

        $this->assertEquals($number * 2, $resultA['testColumn'] + $resultB['testColumn']);
    }
}
