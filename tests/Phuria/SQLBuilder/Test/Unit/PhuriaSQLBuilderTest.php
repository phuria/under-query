<?php

/**
 * This file is part of Phuria SQL Builder package.
 *
 * Copyright (c) 2016 Beniamin Jonatan Šimko
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Phuria\SQLBuilder\Test\Unit;

use Interop\Container\ContainerInterface;
use Phuria\SQLBuilder\Connection\ConnectionInterface;
use Phuria\SQLBuilder\PhuriaSQLBuilder;
use Phuria\SQLBuilder\QueryBuilder\DeleteBuilder;
use Phuria\SQLBuilder\QueryBuilder\InsertBuilder;
use Phuria\SQLBuilder\QueryBuilder\InsertSelectBuilder;
use Phuria\SQLBuilder\QueryBuilder\SelectBuilder;
use Phuria\SQLBuilder\QueryBuilder\UpdateBuilder;

/**
 * @author Beniamin Jonatan Šimko <spam@simko.it>
 */
class PhuriaSQLBuilderTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     * @covers \Phuria\SQLBuilder\PhuriaSQLBuilder
     */
    public function itCreateValidBuilders()
    {
        $phuriaBuilder = new PhuriaSQLBuilder();
        static::assertInstanceOf(SelectBuilder::class, $phuriaBuilder->createSelect());
        static::assertInstanceOf(InsertBuilder::class, $phuriaBuilder->createInsert());
        static::assertInstanceOf(InsertSelectBuilder::class, $phuriaBuilder->createInsertSelect());
        static::assertInstanceOf(DeleteBuilder::class, $phuriaBuilder->createDelete());
        static::assertInstanceOf(UpdateBuilder::class, $phuriaBuilder->createUpdate());
    }

    /**
     * @test
     * @covers \Phuria\SQLBuilder\PhuriaSQLBuilder
     */
    public function itReturnGivenContainer()
    {
        $container = $this->prophesize(ContainerInterface::class)->reveal();
        $phuriaBuilder = new PhuriaSQLBuilder($container);
        static::assertSame($container, $phuriaBuilder->getContainer());
    }

    /**
     * @test
     * @covers \Phuria\SQLBuilder\PhuriaSQLBuilder
     */
    public function itRegisterConnection()
    {
        $phuriaBuilder = new PhuriaSQLBuilder();
        $connection = $this->prophesize(ConnectionInterface::class)->reveal();
        $phuriaBuilder->registerConnection($connection);

        $registeredConnection = $phuriaBuilder->getContainer()
            ->get('phuria.sql_builder.connection_manager')->getConnection();

        static::assertSame($connection, $registeredConnection);
    }
}
