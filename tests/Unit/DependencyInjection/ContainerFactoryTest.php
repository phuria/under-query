<?php

/**
 * This file is part of UnderQuery package.
 *
 * Copyright (c) 2016 Beniamin Jonatan Šimko
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Phuria\UnderQuery\Tests\Unit\DependencyInjection;

use Interop\Container\ContainerInterface;
use Phuria\UnderQuery\Connection\ConnectionManagerInterface;
use Phuria\UnderQuery\DependencyInjection\ContainerFactory;
use Phuria\UnderQuery\Query\QueryFactoryInterface;
use Phuria\UnderQuery\QueryCompiler\QueryCompilerInterface;
use Phuria\UnderQuery\TableFactory\TableFactoryInterface;
use Phuria\UnderQuery\TableRegistry;

/**
 * @author Beniamin Jonatan Šimko <spam@simko.it>
 */
class ContainerFactoryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     * @covers \Phuria\UnderQuery\DependencyInjection\ContainerFactory
     */
    public function itCreateValidInterfaces()
    {
        $factory = new ContainerFactory();

        static::assertInstanceOf(ContainerInterface::class, $container = $factory->create());
        static::assertInstanceOf(ConnectionManagerInterface::class, $container->get('phuria.sql_builder.connection_manager'));
        static::assertInstanceOf(QueryFactoryInterface::class, $container->get('phuria.sql_builder.query_factory'));
        static::assertInstanceOf(QueryCompilerInterface::class, $container->get('phuria.sql_builder.query_compiler'));
        static::assertInstanceOf(TableRegistry::class, $container->get('phuria.sql_builder.table_registry'));
        static::assertInstanceOf(TableFactoryInterface::class, $container->get('phuria.sql_builder.table_factory'));
    }
}
