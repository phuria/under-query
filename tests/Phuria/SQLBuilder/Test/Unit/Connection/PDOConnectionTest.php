<?php

/**
 * This file is part of Phuria SQL Builder package.
 *
 * Copyright (c) 2016 Beniamin Jonatan Šimko
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Phuria\SQLBuilder\Test\Unit\Connection;

use Phuria\SQLBuilder\Connection\PDOConnection;
use Phuria\SQLBuilder\Statement\PDOStatement;

/**
 * @author Beniamin Jonatan Šimko <spam@simko.it>
 */
class PDOConnectionTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     * @covers PDOConnection
     */
    public function itShouldCallQuery()
    {
        $pdo = $this->prophesize(\PDO::class);
        $pdoStmt = $this->prophesize(\PDOStatement::class)->reveal();
        $pdo->query('test')->willReturn($pdoStmt);
        $pdo = $pdo->reveal();

        $connection = new PDOConnection($pdo);
        static::assertInstanceOf(PDOStatement::class, $connection->query('test'));
    }

    /**
     * @test
     * @covers PDOConnection
     */
    public function itShouldCallPrepare()
    {
        $pdo = $this->prophesize(\PDO::class);
        $pdoStmt = $this->prophesize(\PDOStatement::class)->reveal();
        $pdo->prepare('test')->willReturn($pdoStmt);
        $pdo = $pdo->reveal();

        $connection = new PDOConnection($pdo);
        static::assertInstanceOf(PDOStatement::class, $connection->prepare('test'));
    }
}
