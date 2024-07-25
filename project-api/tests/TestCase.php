<?php

namespace Tests;

// use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Facades\DB;

abstract class TestCase extends BaseTestCase
{
    use RefreshDatabase;

    /**
     * @var bool
     */
    protected static bool $initialized = false;

    /**
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();

        if (! self::$initialized) {

            $this->createTestDatabase();

            $this->setTestDatabaseConnection();

            $this->prepareTestDatabase();

            self::$initialized = true;
        }
    }

    /**
     * @return static
     */
    protected function createTestDatabase(): static
    {
        $pdo = DB::getPdo();

        $databaseName = config('database.test_database');
        $query = $pdo->prepare('SELECT SCHEMA_NAME FROM INFORMATION_SCHEMA.SCHEMATA WHERE SCHEMA_NAME = :database_name');

        $query->execute(['database_name' => $databaseName]);

        $result = $query->fetchObject();

        if (! $result) {
            $sql = 'CREATE DATABASE ' . $databaseName;
            $pdo->exec($sql);
        }

        return $this;
    }

    /**
     * Set the test database connection.
     *
     * @return void
     */
    protected function setTestDatabaseConnection(): void
    {
        config()->set('database.connections.mysql.database', config('database.test_database'));

        DB::purge('mysql');

        DB::reconnect('mysql');
    }

    /**
     * Set the test database connection.
     *
     * @return void
     */
    protected function prepareTestDatabase(): void
    {
        $this->artisan('migrate:fresh');

        $this->artisan('db:seed');
    }
}
