<?php

/**
 * This file is part of UnderQuery package.
 *
 * Copyright (c) 2016 Beniamin Jonatan Šimko
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Phuria\UnderQuery\Tests\Unit\TableFactory;

use Phuria\UnderQuery\Table\SubQueryTable;
use Phuria\UnderQuery\Table\DefaultTable;
use Phuria\UnderQuery\TableFactory\TableFactory;
use Phuria\UnderQuery\Tests\Fixtures\ExampleTable;
use Phuria\UnderQuery\Tests\Fixtures\NullQueryBuilder;
use Phuria\UnderQuery\Tests\TestCase\UnderQueryTrait;

/**
 * @author Beniamin Jonatan Šimko <spam@simko.it>
 */
class TableFactoryTest extends \PHPUnit_Framework_TestCase
{
    use UnderQueryTrait;

    /**
     * @test
     * @covers \Phuria\UnderQuery\TableFactory\TableFactory
     */
    public function itCreateUnknownTable()
    {
        $factory = new TableFactory();
        $table = $factory->createNewTable('unknown_table', new NullQueryBuilder());

        static::assertInstanceOf(DefaultTable::class, $table);
    }

    /**
     * @test
     * @covers \Phuria\UnderQuery\TableFactory\TableFactory
     */
    public function itCreateExampleTable()
    {
        $factory = new TableFactory();

        $tableByCallback = $factory->createNewTable(function (ExampleTable $table) {}, new NullQueryBuilder());
        $tableByClass = $factory->createNewTable(ExampleTable::class, new NullQueryBuilder());

        static::assertInstanceOf(ExampleTable::class, $tableByCallback);
        static::assertInstanceOf(ExampleTable::class, $tableByClass);
    }

    /**
     * @test
     * @covers \Phuria\UnderQuery\TableFactory\TableFactory
     */
    public function itCreateSubQueryTable()
    {
        $factory = new TableFactory();
        $qb = new NullQueryBuilder();

        $table = $factory->createNewTable($qb, new NullQueryBuilder());

        static::assertInstanceOf(SubQueryTable::class, $table);
    }

    /**
     * @test
     * @covers \Phuria\UnderQuery\TableFactory\TableFactory
     */
    public function itWillReturnValidTypes()
    {
        $factory = new TableFactory();

        $type = $factory->recognizeType(function (ExampleTable $table) { });
        static::assertSame(TableFactory::TYPE_CLOSURE, $type);

        $type = $factory->recognizeType(ExampleTable::class);
        static::assertSame(TableFactory::TYPE_CLASS_NAME, $type);

        $type = $factory->recognizeType('example_table_name');
        static::assertSame(TableFactory::TYPE_TABLE_NAME, $type);

        $type = $factory->recognizeType(new NullQueryBuilder());
        static::assertSame(TableFactory::TYPE_SUB_QUERY, $type);
    }

    /**
     * @test
     * @covers \Phuria\UnderQuery\TableFactory\TableFactory
     */
    public function itExtractClassName()
    {
        $recognizer = new TableFactory();

        $class = $recognizer->extractClassName(function (ExampleTable $table) {});

        static::assertSame(ExampleTable::class, $class);
    }
}
