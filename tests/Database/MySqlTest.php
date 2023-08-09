<?php declare(strict_types=1);

namespace Cophpee\Tests\Database;

use Cophpee\Components\Database\Connection;
use Cophpee\Components\Facade\DB;
use PHPUnit\Framework\TestCase;

class MySqlTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
        DB::init([
            'connections' => [
                [
                    'name' => 'test_database',
                    'type' => 'mysql',
                    'host' => 'localhost',
                    'schema' => 'information_schema',
                    'username' => 'root',
                    'password' => 'root'
                ]
            ],
            'default' => 'test_database'
        ]);
    }

    public function testConnection() {
        $result = DB::query('SELECT 1 as testColumn')->fetchAll();
        $this->assertCount(1, $result);
    }

    public function testSuccessfulTransaction() {
        $number = 12345;

        DB::begin();
        $resultA = DB::query('SELECT :number as testColumn', ['number' => $number])->fetchRow();
        $resultB = DB::query('SELECT :number as testColumn', ['number' => $number])->fetchRow();
        DB::end();

        $this->assertEquals($number * 2, $resultA['testColumn'] + $resultB['testColumn']);
    }
}
