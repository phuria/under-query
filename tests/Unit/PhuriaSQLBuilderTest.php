<?php

/**
 * This file is part of UnderQuery package.
 *
 * Copyright (c) 2016 Beniamin Jonatan Šimko
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Phuria\UnderQuery\Tests\Unit;

use Interop\Container\ContainerInterface;
use Phuria\UnderQuery\Connection\ConnectionInterface;
use Phuria\UnderQuery\QueryBuilder\DeleteBuilder;
use Phuria\UnderQuery\QueryBuilder\InsertBuilder;
use Phuria\UnderQuery\QueryBuilder\InsertSelectBuilder;
use Phuria\UnderQuery\QueryBuilder\SelectBuilder;
use Phuria\UnderQuery\QueryBuilder\UpdateBuilder;
use Phuria\UnderQuery\UnderQuery;

/**
 * @author Beniamin Jonatan Šimko <spam@simko.it>
 */
class PhuriaSQLBuilderTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     * @covers \Phuria\UnderQuery\UnderQuery
     */
    public function itCreateValidBuilders()
    {
        $phuriaBuilder = new UnderQuery();
        static::assertInstanceOf(SelectBuilder::class, $phuriaBuilder->createSelect());
        static::assertInstanceOf(InsertBuilder::class, $phuriaBuilder->createInsert());
        static::assertInstanceOf(InsertSelectBuilder::class, $phuriaBuilder->createInsertSelect());
        static::assertInstanceOf(DeleteBuilder::class, $phuriaBuilder->createDelete());
        static::assertInstanceOf(UpdateBuilder::class, $phuriaBuilder->createUpdate());
    }

    /**
     * @test
     * @covers \Phuria\UnderQuery\UnderQuery
     */
    public function itReturnGivenContainer()
    {
        $container = $this->prophesize(ContainerInterface::class)->reveal();
        $phuriaBuilder = new UnderQuery($container);
        static::assertSame($container, $phuriaBuilder->getContainer());
    }

    /**
     * @test
     * @covers \Phuria\UnderQuery\UnderQuery
     */
    public function itRegisterConnection()
    {
        $phuriaBuilder = new UnderQuery();
        $connection = $this->prophesize(ConnectionInterface::class)->reveal();
        $phuriaBuilder->registerConnection($connection);

        $registeredConnection = $phuriaBuilder->getContainer()
            ->get('phuria.sql_builder.connection_manager')->getConnection();

        static::assertSame($connection, $registeredConnection);
    }
}
