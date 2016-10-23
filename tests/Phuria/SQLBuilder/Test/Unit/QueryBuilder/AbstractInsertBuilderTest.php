<?php

/**
 * This file is part of Phuria SQL Builder package.
 *
 * Copyright (c) 2016 Beniamin Jonatan Šimko
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Phuria\SQLBuilder\Test\Unit\QueryBuilder;

use Phuria\SQLBuilder\Test\TestCase\QueryBuilderTrait;

/**
 * @author Beniamin Jonatan Šimko <spam@simko.it>
 */
class AbstractInsertBuilderTest extends \PHPUnit_Framework_TestCase
{
    use QueryBuilderTrait;

    /**
     * @test
     * @covers \Phuria\SQLBuilder\QueryBuilder\AbstractInsertBuilder
     */
    public function itCreateRootTable()
    {
        $qb = static::phuriaSQL()->createInsert();

        $qb->into('example_table');

        static::assertCount(1, $qb->getRootTables());
    }

    /**
     * @test
     * @covers \Phuria\SQLBuilder\QueryBuilder\AbstractInsertBuilder
     */
    public function itUseGivenColumns()
    {
        $qb = static::phuriaSQL()->createInsert();

        $qb->into('example_table', ['foo', 'boo']);

        static::assertSame(['foo', 'boo'], $qb->getColumns());
    }

    /**
     * @test
     * @covers \Phuria\SQLBuilder\QueryBuilder\AbstractInsertBuilder
     */
    public function itSetColumns()
    {
        $qb = static::phuriaSQL()->createInsert();

        static::assertSame([], $qb->getColumns());
        $qb->setColumns(['a', 'b']);
        static::assertSame(['a', 'b'], $qb->getColumns());
    }
}
