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
use Phuria\UnderQuery\Table\UnknownTable;
use Phuria\UnderQuery\TableFactory\TableFactory;
use Phuria\UnderQuery\TableRegistry;
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
        $factory = new TableFactory(new TableRegistry());
        $table = $factory->createNewTable('unknown_table', new NullQueryBuilder());

        static::assertInstanceOf(UnknownTable::class, $table);
    }

    /**
     * @test
     * @covers \Phuria\UnderQuery\TableFactory\TableFactory
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
     * @covers \Phuria\UnderQuery\TableFactory\TableFactory
     */
    public function itCreateSubQueryTable()
    {
        $factory = new TableFactory(new TableRegistry());
        $qb = new NullQueryBuilder();

        $table = $factory->createNewTable($qb, new NullQueryBuilder());

        static::assertInstanceOf(SubQueryTable::class, $table);
    }
}
