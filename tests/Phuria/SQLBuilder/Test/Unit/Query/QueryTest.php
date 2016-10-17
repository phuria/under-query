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
    public function itShouldCallConnection()
    {
        $paramManager = new ParameterManager();
        $connection = new NullConnection();

        $query = new Query('', $paramManager, $connection);

        static::assertSame(null, $query->fetchScalar());
        static::assertSame([], $query->fetchAll());
        static::assertSame(null, $query->fetchRow());
        static::assertSame(0, $query->rowCount());
    }
}
