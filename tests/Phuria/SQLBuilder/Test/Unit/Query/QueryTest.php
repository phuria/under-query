<?php

/**
 * This file is part of Phuria SQL Builder package.
 *
 * Copyright (c) 2016 Beniamin Jonatan Šimko
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Phuria\SQLBuilder\Test\Unit\Query;

use Phuria\SQLBuilder\Connection\ConnectionInterface;
use Phuria\SQLBuilder\Connection\NullConnection;
use Phuria\SQLBuilder\Parameter\ParameterManager;
use Phuria\SQLBuilder\Query\Query;

/**
 * @author Beniamin Jonatan Šimko <spam@simko.it>
 */
class QueryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @return Query
     */
    private function createTestQuery()
    {
        $paramManager = new ParameterManager();
        $connection = new NullConnection();

        return new Query('', $paramManager, $connection);
    }

    /**
     * @test
     * @covers \Phuria\SQLBuilder\Query\Query
     */
    public function itShouldReturnScalarValue()
    {
        $parameterManager = new ParameterManager();
        $connection = $this->prophesize(ConnectionInterface::class);
        $connection->fetchScalar('', [])->willReturn(100);
        $connection = $connection->reveal();

        $query = new Query('', $parameterManager, $connection);

        static::assertSame(100, $query->fetchScalar());
    }

    /**
     * @test
     * @covers \Phuria\SQLBuilder\Query\Query
     */
    public function isShouldReturnGivenAttributes()
    {
        $parameterManager = new ParameterManager();
        $connection = $this->prophesize(ConnectionInterface::class)->reveal();

        $query = new Query('test', $parameterManager, $connection);

        static::assertSame('test', $query->getSQL());
        static::assertSame($connection, $query->getConnection());
        static::assertSame($parameterManager, $query->getParameterManager());
    }

    /**
     * @test
     * @covers \Phuria\SQLBuilder\Query\Query
     */
    public function itShouldCallConnection()
    {
        $query = $this->createTestQuery();

        static::assertSame(null, $query->fetchScalar());
        static::assertSame([], $query->fetchAll());
        static::assertSame(null, $query->fetchRow());
        static::assertSame(0, $query->rowCount());
        static::assertSame(0, $query->execute());
    }

    /**
     * @test
     * @covers \Phuria\SQLBuilder\Query\Query
     */
    public function itSetParameter()
    {
        $query = $this->createTestQuery();
        $query->setParameter('test', 1234);

        $param = $query->getParameterManager()->getParameter('test');

        static::assertSame($param->getValue(), 1234);
        static::assertSame($param->getName(), 'test');
    }
}
