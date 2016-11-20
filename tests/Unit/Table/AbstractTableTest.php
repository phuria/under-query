<?php

/**
 * This file is part of UnderQuery package.
 *
 * Copyright (c) 2016 Beniamin Jonatan Šimko
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Phuria\UnderQuery\Tests\Unit\Table;

use Phuria\UnderQuery\JoinType;
use Phuria\UnderQuery\Table\DefaultTable;
use Phuria\UnderQuery\Tests\TestCase\UnderQueryTrait;

/**
 * @author Beniamin Jonatan Šimko <spam@simko.it>
 */
class AbstractTableTest extends \PHPUnit_Framework_TestCase
{
    use UnderQueryTrait;

    /**
     * @return DefaultTable
     */
    private function createTestTable()
    {
        $qb = static::underQuery()->createSelect();
        $table = new DefaultTable($qb);

        return $table;
    }

    /**
     * @test
     * @covers \Phuria\UnderQuery\Table\AbstractTable
     */
    public function itDefaultIsNotJoin()
    {
        static::assertFalse($this->createTestTable()->isJoin());
    }

    /**
     * @test
     * @covers \Phuria\UnderQuery\Table\AbstractTable
     */
    public function itCreateColumnReference()
    {
        $table = $this->createTestTable();

        $column = $table->column('test');

        static::assertContains('test', $column);
    }

    /**
     * @test
     * @covers \Phuria\UnderQuery\Table\AbstractTable
     */
    public function itCanBeString()
    {
        $table = $this->createTestTable();

        static::assertTrue(is_string((string) $table));
    }

    /**
     * @test
     * @covers \Phuria\UnderQuery\Table\AbstractTable
     */
    public function itShouldHaveAlias()
    {
        $table = $this->createTestTable();

        $table->setAlias('test');

        static::assertSame('test', $table->getAlias());
        static::assertSame('test', $table->getAliasOrName());
    }

    /**
     * @test
     * @covers \Phuria\UnderQuery\Table\AbstractTable
     */
    public function itShouldHaveConfigurableJoins()
    {
        $table = $this->createTestTable();

        $table->setJoinType(JoinType::INNER_JOIN);
        $table->setNaturalJoin(true);
        $table->setOuterJoin(true);
        $table->joinOn('0 = 0');

        static::assertTrue($table->isJoin());
        static::assertTrue($table->isNaturalJoin());
        static::assertTrue($table->isOuterJoin());
        static::assertSame(JoinType::INNER_JOIN, $table->getJoinType());
        static::assertSame('0 = 0', $table->getJoinOn());
    }
}
