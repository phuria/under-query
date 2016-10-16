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
use Phuria\SQLBuilder\Statement\StatementInterface;

/**
 * @author Beniamin Jonatan Šimko <spam@simko.it>
 */
class QueryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     * @covers Query
     */
    public function itShouldReturnScalarValue()
    {
        $parameterManager = $this->prophesize(ParameterManagerInterface::class)->reveal();
        $connection = $this->prophesize(ConnectionInterface::class);
        $statement = $this->prophesize(StatementInterface::class);
        $statement->execute()->willReturn(null);
        $statement->fetch(\PDO::FETCH_ASSOC)->willReturn(['result' => 100]);
        $statement = $statement->reveal();
        $connection->prepare('')->willReturn($statement);
        $connection = $connection->reveal();

        $query = new Query('', $parameterManager, $connection);

        static::assertSame(100, $query->fetchScalar());
    }
}
