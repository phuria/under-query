<?php

/**
 * This file is part of UnderQuery package.
 *
 * Copyright (c) 2016 Beniamin Jonatan Šimko
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Phuria\UnderQuery\Tests\TestCase;

use Doctrine\DBAL\Driver\Connection as ConnectionInterface;
use Doctrine\DBAL\DriverManager;

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
            $this->connection = $this->createDefaultDBConnection(
                $this->createPDOConnection(),
                $GLOBALS['DB_DBNAME']
            );
        }

        return $this->connection;
    }

    protected function createPDOConnection()
    {
        return new \PDO(
            "{$GLOBALS['DB_TYPE']}:dbname={$GLOBALS['DB_DBNAME']};host={$GLOBALS['DB_HOST']}",
            $GLOBALS['DB_USER'],
            $GLOBALS['DB_PASSWORD']
        );
    }

    /**
     * @return ConnectionInterface
     */
    protected function createDoctrineConnection()
    {
        return DriverManager::getConnection([
            'dbname'   => $GLOBALS['DB_DBNAME'],
            'user'     => $GLOBALS['DB_USER'],
            'password' => $GLOBALS['DB_PASSWORD'],
            'host'     => $GLOBALS['DB_HOST'],
            'driver'   => $GLOBALS['DB_DRIVER']
        ]);
    }

    /**
     * @inheritdoc
     */
    public function getDataSet()
    {
        return new \PHPUnit_Extensions_Database_DataSet_YamlDataSet(
            __DIR__ . '/../Resources/data_set.yml'
        );
    }
}