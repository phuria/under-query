<?php

/**
 * This file is part of Phuria SQL Builder package.
 *
 * Copyright (c) 2016 Beniamin Jonatan Šimko
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Phuria\SQLBuilder\Test\Unit\Table;

use Phuria\SQLBuilder\Table\UnknownTable;
use Phuria\SQLBuilder\Test\TestCase\QueryBuilderTrait;

/**
 * @author Beniamin Jonatan Šimko <spam@simko.it>
 */
class AbstractTableTest extends \PHPUnit_Framework_TestCase
{
    use QueryBuilderTrait;

    /**
     * @return UnknownTable
     */
    private function createTestTable()
    {
        $qb = static::phuriaSQL()->createSelect();
        $table = new UnknownTable($qb);

        return $table;
    }

    /**
     * @test
     * @covers \Phuria\SQLBuilder\Table\AbstractTable
     */
    public function itDefaultIsNotJoin()
    {
        static::assertFalse($this->createTestTable()->isJoin());
    }

    /**
     * @test
     * @covers \Phuria\SQLBuilder\Table\AbstractTable
     */
    public function itCreateColumnReference()
    {
        $table = $this->createTestTable();

        $column = $table->column('test');

        static::assertContains('test', $column);
    }

    /**
     * @test
     * @covers \Phuria\SQLBuilder\Table\AbstractTable
     */
    public function itCanBeString()
    {
        $table = $this->createTestTable();

        static::assertTrue(is_string((string) $table));
    }

    /**
     * @test
     * @covers \Phuria\SQLBuilder\Table\AbstractTable
     */
    public function itShouldHaveAlias()
    {
        $table = $this->createTestTable();

        $table->setAlias('test');

        static::assertSame('test', $table->getAlias());
        static::assertSame('test', $table->getAliasOrName());
    }
}
