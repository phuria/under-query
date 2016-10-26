<?php

/**
 * This file is part of UnderQuery package.
 *
 * Copyright (c) 2016 Beniamin Jonatan Šimko
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Phuria\UnderQuery\Tests\Unit\Query;

use Phuria\UnderQuery\Connection\ConnectionInterface;
use Phuria\UnderQuery\Connection\NullConnection;
use Phuria\UnderQuery\Parameter\ParameterCollection;
use Phuria\UnderQuery\Query\Query;

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
        $paramManager = new ParameterCollection();
        $connection = new NullConnection();

        return new Query('', $paramManager, $connection);
    }

    /**
     * @test
     * @covers \Phuria\UnderQuery\Query\Query
     */
    public function itShouldReturnScalarValue()
    {
        $parameterManager = new ParameterCollection();
        $connection = $this->prophesize(ConnectionInterface::class);
        $connection->fetchScalar('', [])->willReturn(100);
        $connection = $connection->reveal();

        $query = new Query('', $parameterManager, $connection);

        static::assertSame(100, $query->fetchScalar());
    }

    /**
     * @test
     * @covers \Phuria\UnderQuery\Query\Query
     */
    public function isShouldReturnGivenAttributes()
    {
        $parameterManager = new ParameterCollection();
        $connection = $this->prophesize(ConnectionInterface::class)->reveal();

        $query = new Query('test', $parameterManager, $connection);

        static::assertSame('test', $query->getSQL());
        static::assertSame($connection, $query->getConnection());
        static::assertSame($parameterManager, $query->getParameterCollection());
    }

    /**
     * @test
     * @covers \Phuria\UnderQuery\Query\Query
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
     * @covers \Phuria\UnderQuery\Query\Query
     */
    public function itSetParameter()
    {
        $query = $this->createTestQuery();
        $query->setParameter('test', 1234);

        $param = $query->getParameterCollection()->getParameter('test');

        static::assertSame($param->getValue(), 1234);
        static::assertSame($param->getName(), 'test');
    }
}
