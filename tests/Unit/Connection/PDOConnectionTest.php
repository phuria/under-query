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
        $pdoStmt = $this->prophesize(\PDOStatement::class);
        $pdoStmt->execute()->willReturn(null);
        $pdoStmt->rowCount()->willReturn(1);
        $pdoStmt->fetch(\PDO::FETCH_COLUMN)->willReturn('test');
        $pdoStmt = $pdoStmt->reveal();
        $pdo->prepare('test')->willReturn($pdoStmt);
        $pdo = $pdo->reveal();

        $connection = new PDOConnection($pdo);
        static::assertSame('test', $connection->fetchScalar('test'));
    }

    /**
     * @test
     * @covers \Phuria\UnderQuery\Connection\PDOConnection
     */
    public function itShouldFetchAll()
    {
        $result = [[1,2],[3,4]];

        $pdo = $this->prophesize(\PDO::class);
        $pdoStmt = $this->prophesize(\PDOStatement::class);
        $pdoStmt->execute()->willReturn(null);
        $pdoStmt->rowCount()->willReturn(2);
        $pdoStmt->fetchAll(\PDO::FETCH_ASSOC)->willReturn($result);
        $pdoStmt = $pdoStmt->reveal();
        $pdo->prepare('test')->willReturn($pdoStmt);
        $pdo = $pdo->reveal();

        $connection = new PDOConnection($pdo);
        static::assertSame($result, $connection->fetchAll('test'));
    }

    /**
     * @test
     * @covers \Phuria\UnderQuery\Connection\PDOConnection
     */
    public function itWillBindParameters()
    {
        $parameter = new QueryParameter('param1');
        $parameter->setValue(100);

        $pdo = $this->prophesize(\PDO::class);
        $pdoStmt = $this->prophesize(\PDOStatement::class);
        $pdoStmt->bindValue($parameter->getName(), $parameter->getValue())->willReturn(null);
        $pdoStmt->execute()->willReturn(null);
        $pdoStmt->rowCount()->willReturn(0);
        $pdoStmt = $pdoStmt->reveal();
        $pdo->prepare('test')->willReturn($pdoStmt);
        $pdo = $pdo->reveal();

        $connection = new PDOConnection($pdo);
        $connection->execute('test', [$parameter]);
    }
}
