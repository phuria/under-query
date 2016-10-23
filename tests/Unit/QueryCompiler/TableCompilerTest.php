<?php

/**
 * This file is part of Phuria SQL Builder package.
 *
 * Copyright (c) 2016 Beniamin Jonatan Šimko
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Phuria\UnderQuery\Tests\Unit\QueryCompiler;

use Phuria\UnderQuery\JoinType;
use Phuria\UnderQuery\QueryCompiler\TableCompiler;
use Phuria\UnderQuery\Tests\Fixtures\ExampleTable;
use Phuria\UnderQuery\Tests\Fixtures\NullQueryBuilder;

/**
 * @author Beniamin Jonatan Šimko <spam@simko.it>
 */
class TableCompilerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @return ExampleTable
     */
    private function createTable()
    {
        return new ExampleTable(new NullQueryBuilder());
    }

    /**
     * @test
     * @covers \Phuria\UnderQuery\QueryCompiler\TableCompiler
     */
    public function join()
    {
        $compiler = new TableCompiler();

        $table = $this->createTable();
        $table->setJoinType(JoinType::JOIN);

        static::assertSame('JOIN example', $compiler->compileTableDeclaration($table));
    }

    /**
     * @test
     * @covers \Phuria\UnderQuery\QueryCompiler\TableCompiler
     */
    public function leftJoin()
    {
        $compiler = new TableCompiler();

        $table = $this->createTable();
        $table->setJoinType(JoinType::LEFT_JOIN);

        static::assertSame('LEFT JOIN example', $compiler->compileTableDeclaration($table));
    }

    /**
     * @test
     * @covers \Phuria\UnderQuery\QueryCompiler\TableCompiler
     */
    public function naturalRightJoin()
    {
        $compiler = new TableCompiler();

        $table = $this->createTable();
        $table->setJoinType(JoinType::RIGHT_JOIN);
        $table->setNaturalJoin(true);

        static::assertSame('NATURAL RIGHT JOIN example', $compiler->compileTableDeclaration($table));
    }

    /**
     * @test
     * @covers \Phuria\UnderQuery\QueryCompiler\TableCompiler
     */
    public function naturalLeftOuterJoin()
    {
        $compiler = new TableCompiler();

        $table = $this->createTable();
        $table->setJoinType(JoinType::LEFT_JOIN);
        $table->setNaturalJoin(true);
        $table->setOuterJoin(true);

        static::assertSame('NATURAL LEFT OUTER JOIN example', $compiler->compileTableDeclaration($table));
    }

    /**
     * @test
     * @covers \Phuria\UnderQuery\QueryCompiler\TableCompiler
     */
    public function straightJoin()
    {
        $compiler = new TableCompiler();

        $table = $this->createTable();
        $table->setJoinType(JoinType::STRAIGHT_JOIN);

        static::assertSame('STRAIGHT_JOIN example', $compiler->compileTableDeclaration($table));
    }

    /**
     * @test
     * @covers \Phuria\UnderQuery\QueryCompiler\TableCompiler
     */
    public function itCompileAlias()
    {
        $compiler = new TableCompiler();

        $table = $this->createTable();
        $table->setAlias('e');

        static::assertSame('example AS e', $compiler->compileTableDeclaration($table));
    }

    /**
     * @test
     * @covers \Phuria\UnderQuery\QueryCompiler\TableCompiler
     */
    public function itCompileOnClause()
    {
        $compiler = new TableCompiler();

        $table = $this->createTable();
        $table->joinOn('1=1');

        static::assertSame('example ON 1=1', $compiler->compileTableDeclaration($table));
    }
}
