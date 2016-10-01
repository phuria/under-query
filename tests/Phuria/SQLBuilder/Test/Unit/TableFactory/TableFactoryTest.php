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

use Phuria\SQLBuilder\Table\UnknownTable;
use Phuria\SQLBuilder\TableFactory\TableFactory;
use Phuria\SQLBuilder\TableRegistry;
use Phuria\SQLBuilder\Test\Helper\ExampleTable;
use Phuria\SQLBuilder\Test\Helper\NullQueryBuilder;

/**
 * @author Beniamin Jonatan Šimko <spam@simko.it>
 */
class TableFactoryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function itCreateUnknownTable()
    {
        $factory = new TableFactory(new TableRegistry());
        $table = $factory->createNewTable('unknown_table', new NullQueryBuilder());

        static::assertInstanceOf(UnknownTable::class, $table);
    }

    /**
     * @test
     */
    public function itCreateExampleTable()
    {
        $registry = new TableRegistry();
        $registry->registerTable(ExampleTable::class, 'example');
        $factory = new TableFactory($registry);
        $table = $factory->createNewTable('example', new NullQueryBuilder());

        static::assertInstanceOf(ExampleTable::class, $table);
    }
}
