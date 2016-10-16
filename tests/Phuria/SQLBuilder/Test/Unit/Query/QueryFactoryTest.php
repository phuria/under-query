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
use Phuria\SQLBuilder\Connection\ConnectionManager;
use Phuria\SQLBuilder\Parameter\ParameterManager;
use Phuria\SQLBuilder\Query\Query;
use Phuria\SQLBuilder\Query\QueryFactory;

/**
 * @author Beniamin Jonatan Šimko <spam@simko.it>
 */
class QueryFactoryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function itBuildQuery()
    {
        $connectionManager = new ConnectionManager();
        $queryFactory = new QueryFactory($connectionManager);
        $query = $queryFactory->buildQuery('SQL', new ParameterManager());

        static::assertInstanceOf(Query::class, $query);
        static::assertSame('SQL', $query->getSQL());
        static::assertInstanceOf(ConnectionInterface::class, $query->getConnection());
    }
}
