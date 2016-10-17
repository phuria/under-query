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
use Phuria\SQLBuilder\Connection\ConnectionManagerInterface;
use Phuria\SQLBuilder\Parameter\ParameterManagerInterface;
use Phuria\SQLBuilder\Query\QueryFactory;

/**
 * @author Beniamin Jonatan Šimko <spam@simko.it>
 */
class QueryFactoryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     * @covers \Phuria\SQLBuilder\Query\QueryFactory
     */
    public function itShouldCreateQueryWithDefaultConnection()
    {
        $connectionManager = $this->prophesize(ConnectionManagerInterface::class);
        $connection = $this->prophesize(ConnectionInterface::class)->reveal();
        $connectionManager->getConnection(null)->willReturn($connection);
        $connectionManager = $connectionManager->reveal();
        $parameterManager = $this->prophesize(ParameterManagerInterface::class)->reveal();

        $queryFactory = new QueryFactory($connectionManager);
        $query = $queryFactory->buildQuery('SQL', $parameterManager);

        static::assertSame('SQL', $query->getSQL());
        static::assertSame($parameterManager, $query->getParameterManager());
    }

    /**
     * @test
     * @covers \Phuria\SQLBuilder\Query\QueryFactory
     */
    public function itShouldCreateQueryWithConnectionHint()
    {
        $connectionManager = $this->prophesize(ConnectionManagerInterface::class);
        $connection = $this->prophesize(ConnectionInterface::class)->reveal();
        $connectionManager->getConnection($connection)->willReturn($connection);
        $connectionManager = $connectionManager->reveal();
        $parameterManager = $this->prophesize(ParameterManagerInterface::class)->reveal();

        $queryFactory = new QueryFactory($connectionManager);
        $query = $queryFactory->buildQuery('SQL', $parameterManager, $connection);

        static::assertSame('SQL', $query->getSQL());
        static::assertSame($parameterManager, $query->getParameterManager());
    }
}
