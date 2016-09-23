<?php

/**
 * This file is part of Phuria SQL Builder package.
 *
 * Copyright (c) 2016 Beniamin Jonatan Šimko
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Phuria\SQLBuilder\Test\TestCase;

use Phuria\SQLBuilder\Connection\PDOConnection;

/**
 * @author Beniamin Jonatan Šimko <spam@simko.it>
 */
abstract class DatabaseTestCase extends \PHPUnit_Extensions_Database_TestCase
{
    /**
     * @var \PHPUnit_Extensions_Database_DB_IDatabaseConnection $connection
     */
    private $connection;

    /**
     * @var \PDO $pdo
     */
    protected static $pdo;

    /**
     * @inheritdoc
     */
    protected function getConnection()
    {
        if (null === $this->connection) {
            $this->connection = $this->createDefaultDBConnection(static::getPDOConnection(), $GLOBALS['DB_DBNAME']);
        }

        return $this->connection;
    }

    /**
     * @return \PDO
     */
    protected static function getPDOConnection()
    {
        if (null === static::$pdo) {
            static::$pdo = new \PDO($GLOBALS['DB_DSN'], $GLOBALS['DB_USER'], $GLOBALS['DB_PASSWORD']);
        }

        return static::$pdo;
    }

    /**
     * @return PDOConnection
     */
    protected function createQueryConnection()
    {
        return new PDOConnection($this->getPDOConnection());
    }

    /**
     * @inheritdoc
     */
    public function getDataSet()
    {
        return new \PHPUnit_Extensions_Database_DataSet_YamlDataSet(
            dirname(__FILE__) . '/../_resources/data_set.yml'
        );
    }
}