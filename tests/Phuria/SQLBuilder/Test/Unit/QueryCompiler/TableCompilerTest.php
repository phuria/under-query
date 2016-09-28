<?php

/**
 * This file is part of Phuria SQL Builder package.
 *
 * Copyright (c) 2016 Beniamin Jonatan Šimko
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Phuria\SQLBuilder\Test\Unit\QueryCompiler;

use Phuria\SQLBuilder\JoinType;
use Phuria\SQLBuilder\QueryCompiler\TableCompiler;
use Phuria\SQLBuilder\Test\Helper\ExampleTable;
use Phuria\SQLBuilder\Test\Helper\NullQueryBuilder;

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
     */
    public function straightJoin()
    {
        $compiler = new TableCompiler();

        $table = $this->createTable();
        $table->setJoinType(JoinType::STRAIGHT_JOIN);

        static::assertSame('STRAIGHT_JOIN example', $compiler->compileTableDeclaration($table));
    }
}
