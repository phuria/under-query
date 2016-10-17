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
use Phuria\SQLBuilder\Parameter\ParameterManagerInterface;
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
        $parameterManager = $this->prophesize(ParameterManagerInterface::class);
        $parameterManager->toArray()->willReturn([]);
        $parameterManager = $parameterManager->reveal();
        $connection = $this->prophesize(ConnectionInterface::class);
        $connection->fetchScalar('', [])->willReturn(100);
        $connection = $connection->reveal();

        $query = new Query('', $parameterManager, $connection);

        static::assertSame(100, $query->fetchScalar());
    }
}
