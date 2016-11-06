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
}
