<?php

namespace MixerApi\Test\TestCase;

use Cake\Database\Connection;
use Cake\Database\Driver\Mysql;
use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;
use MixerApi\Welcome;

class WelcomeTest extends TestCase
{
    use IntegrationTestTrait;

    public function setUp(): void
    {
        parent::setUp();
    }

    public function test_welcome(): void
    {
        $this->assertIsArray((new Welcome())->info());
    }

    public function test_old_php_version_exception(): void
    {
        $this->expectException(\RuntimeException::class);
        (new Welcome('7.0.0'))->info();
    }

    public function test_database_connection_failed(): void
    {
        $info = (new Welcome(null, new Connection(['driver' => new Mysql()])))->info();
        $this->assertNotEquals(Welcome::DATABASE_CONNECTED_MSG, $info['database']);
    }
}
