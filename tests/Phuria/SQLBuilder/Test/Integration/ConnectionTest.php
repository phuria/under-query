<?php

/**
 * This file is part of Phuria SQL Builder package.
 *
 * Copyright (c) 2016 Beniamin Jonatan Šimko
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Phuria\SQLBuilder\Test\Integration;

use Phuria\SQLBuilder\Connection\ConnectionInterface;
use Phuria\SQLBuilder\Test\TestCase\DatabaseTestCase;
use Phuria\SQLBuilder\Test\TestCase\QueryBuilderTrait;

/**
 * @author Beniamin Jonatan Šimko <spam@simko.it>
 */
class ConnectionTest extends DatabaseTestCase
{
    use QueryBuilderTrait;

    /**
     * @test
     * @coversNothing
     */
    public function itHasDefaultConnection()
    {
        $qbFactory = static::phuriaSQL();

        $connection = $this->prophesize(ConnectionInterface::class)->reveal();
        $qbFactory->registerConnection($connection);

        $qb = $qbFactory->createSelect();
        $qb->addSelect('*');
        $qb->from('user');
        $query = $qb->buildQuery();

        static::assertSame($connection, $query->getConnection());
    }
}