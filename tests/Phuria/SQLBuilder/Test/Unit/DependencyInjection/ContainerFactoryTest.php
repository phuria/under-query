<?php

/**
 * This file is part of Phuria SQL Builder package.
 *
 * Copyright (c) 2016 Beniamin Jonatan Šimko
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Phuria\SQLBuilder\Test\Unit\DependencyInjection;

use Interop\Container\ContainerInterface;
use Phuria\SQLBuilder\Connection\ConnectionManagerInterface;
use Phuria\SQLBuilder\DependencyInjection\ContainerFactory;
use Phuria\SQLBuilder\Query\QueryFactoryInterface;
use Phuria\SQLBuilder\QueryCompiler\QueryCompilerInterface;
use Phuria\SQLBuilder\TableRegistry;

/**
 * @author Beniamin Jonatan Šimko <spam@simko.it>
 */
class ContainerFactoryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     * @covers \Phuria\SQLBuilder\DependencyInjection\ContainerFactory
     */
    public function itCreateValidInterfaces()
    {
        $factory = new ContainerFactory();

        static::assertInstanceOf(ContainerInterface::class, $container = $factory->create());
        static::assertInstanceOf(ConnectionManagerInterface::class, $container->get('phuria.sql_builder.connection_manager'));
        static::assertInstanceOf(QueryFactoryInterface::class, $container->get('phuria.sql_builder.query_factory'));
        static::assertInstanceOf(QueryCompilerInterface::class, $container->get('phuria.sql_builder.query_compiler'));
        static::assertInstanceOf(TableRegistry::class, $container->get('phuria.sql_builder.table_registry'));
    }
}
