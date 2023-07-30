<?php declare(strict_types=1);

namespace Cophpee\Tests\Database;

use Cophpee\Components\Database\Connection;
use PHPUnit\Framework\TestCase;

class MySqlTest extends TestCase
{
    public function testConnection() {
        $connection = new Connection([
            'type' => 'mysql',
            'host' => 'localhost',
            'schema' => 'information_schema',
            'username' => 'root',
            'password' => 'root'
        ]);

        $result = $connection->query('SELECT 1 as testColumn')->fetchAll();
        $this->assertEquals(1, count($result));
    }
}
