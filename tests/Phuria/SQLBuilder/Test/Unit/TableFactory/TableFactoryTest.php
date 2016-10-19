<?php

/**
 * This file is part of Phuria SQL Builder package.
 *
 * Copyright (c) 2016 Beniamin Jonatan Šimko
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Phuria\SQLBuilder\Test\Unit\TableFactory;

use Phuria\SQLBuilder\Table\SubQueryTable;
use Phuria\SQLBuilder\Table\UnknownTable;
use Phuria\SQLBuilder\TableFactory\TableFactory;
use Phuria\SQLBuilder\TableRegistry;
use Phuria\SQLBuilder\Test\Fixtures\ExampleTable;
use Phuria\SQLBuilder\Test\Fixtures\NullQueryBuilder;
use Phuria\SQLBuilder\Test\TestCase\QueryBuilderTrait;

/**
 * @author Beniamin Jonatan Šimko <spam@simko.it>
 */
class TableFactoryTest extends \PHPUnit_Framework_TestCase
{
    use QueryBuilderTrait;

    /**
     * @test
     * @covers \Phuria\SQLBuilder\TableFactory\TableFactory
     */
    public function itCreateUnknownTable()
    {
        $factory = new TableFactory(new TableRegistry());
        $table = $factory->createNewTable('unknown_table', new NullQueryBuilder());

        static::assertInstanceOf(UnknownTable::class, $table);
    }

    /**
     * @test
     * @covers \Phuria\SQLBuilder\TableFactory\TableFactory
     */
    public function itCreateExampleTable()
    {
        $registry = new TableRegistry();
        $registry->registerTable(ExampleTable::class, 'example');
        $factory = new TableFactory($registry);

        $table = $factory->createNewTable('example', new NullQueryBuilder());
        $tableByCallback = $factory->createNewTable(function (ExampleTable $table) {}, new NullQueryBuilder());
        $tableByClass = $factory->createNewTable(ExampleTable::class, new NullQueryBuilder());

        static::assertInstanceOf(ExampleTable::class, $table);
        static::assertInstanceOf(ExampleTable::class, $tableByCallback);
        static::assertInstanceOf(ExampleTable::class, $tableByClass);
    }

    /**
     * @test
     * @covers \Phuria\SQLBuilder\TableFactory\TableFactory
     */
    public function itCreateSubQueryTable()
    {
        $factory = new TableFactory(new TableRegistry());
        $qb = new NullQueryBuilder();

        $table = $factory->createNewTable($qb, new NullQueryBuilder());

        static::assertInstanceOf(SubQueryTable::class, $table);
    }
}
