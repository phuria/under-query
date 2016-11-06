<?php

/**
 * This file is part of UnderQuery package.
 *
 * Copyright (c) 2016 Beniamin Jonatan Šimko
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Phuria\UnderQuery\Tests\Unit\Connection;

use Phuria\UnderQuery\Connection\PDOConnection;
use Phuria\UnderQuery\Parameter\QueryParameter;
use Phuria\UnderQuery\Statement\StatementInterface;

/**
 * @author Beniamin Jonatan Šimko <spam@simko.it>
 */
class PDOConnectionTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     * @covers \Phuria\UnderQuery\Connection\PDOConnection
     */
    public function itShouldFetchScalar()
    {
        $pdo = $this->prophesize(\PDO::class);
        $pdoStmt = $this->prophesize(\PDOStatement::class)->reveal();
        $pdo->prepare('test')->willReturn($pdoStmt);
        $pdo = $pdo->reveal();

        $connection = new PDOConnection($pdo);
        static::assertInstanceOf(StatementInterface::class, $connection->prepareStatement('test', []));
    }

    /**
     * @test
     * @covers \Phuria\UnderQuery\Connection\PDOConnection
     */
    public function isShouldBindParameters()
    {
        $pdo = $this->prophesize(\PDO::class);
        $pdoStmt = $this->prophesize(\PDOStatement::class);
        $pdoStmt->bindValue('foo', 'boo')->willReturn(null);
        $pdoStmt->bindValue('foo2', 'boo2')->willReturn(null);
        $pdoStmt = $pdoStmt->reveal();
        $pdo->prepare('test')->willReturn($pdoStmt);
        $pdo = $pdo->reveal();

        $connection = new PDOConnection($pdo);
        $stmt = $connection->prepareStatement('test', [
            (new QueryParameter('foo'))->setValue('boo'),
            (new QueryParameter('foo2'))->setValue('boo2')
        ]);

        static::assertInstanceOf(StatementInterface::class, $stmt);
    }

    /**
     * @test
     * @covers \Phuria\UnderQuery\Connection\PDOConnection
     */
    public function itReturnWrappedConnection()
    {
        $pdo = $this->prophesize(\PDO::class)->reveal();

        $connection = new PDOConnection($pdo);
        static::assertSame($pdo, $connection->getWrappedConnection());
    }
}
