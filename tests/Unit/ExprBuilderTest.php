<?php

/**
 * This file is part of Phuria SQL Builder package.
 *
 * Copyright (c) 2016 Beniamin Jonatan Šimko
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Phuria\QueryBuilder\Test\Unit;

use Phuria\QueryBuilder\ExprBuilder;

/**
 * @author Beniamin Jonatan Šimko <spam@simko.it>
 */
class ExprBuilderTest extends \PHPUnit_Framework_TestCase
{
    public function testSum1()
    {
        $exp = new ExprBuilder('1');
        $exp = $exp->sum();

        static::assertSame('SUM(1)', $exp->compile());
    }

    public function testSumMax()
    {
        /** @var ExprBuilder $exp */
        $exp = new ExprBuilder('test');
        $exp = $exp->max()->sum();

        static::assertSame('SUM(MAX(test))', $exp->compile());
    }

    public function testIfNull()
    {
        $exp = new ExprBuilder('test');
        $exp = $exp->ifNull('0');

        static::assertSame('IFNULL(test, 0)', $exp->compile());
    }

    public function testTwoArguments()
    {
        $exp = new ExprBuilder('TE', 'ST');

        static::assertSame('TEST', $exp->compile());
    }

    /**
     * @test
     */
    public function itWillUseUTF8()
    {
        $exp = (new ExprBuilder(10, 20, 30))->char('utf8');

        static::assertSame('CHAR(10, 20, 30 USING utf8)', $exp->compile());
    }

    public function testBetween()
    {
        $exp = (new ExprBuilder('test'))->between(10, 20);

        static::assertSame('test BETWEEN 10 AND 20', $exp->compile());
    }

    public function testNotBetween()
    {
        $exp = (new ExprBuilder('test'))->notBetween(10, 20);

        static::assertSame('test NOT BETWEEN 10 AND 20', $exp->compile());
    }

    public function testCoalesce()
    {
        $exp = (new ExprBuilder('NULL', 'NULL', 'NULL'))->coalesce();

        static::assertSame('COALESCE(NULL, NULL, NULL)', $exp->compile());
    }

    public function testIn()
    {
        $exp = (new ExprBuilder('test'))->in(1, 2, 3);

        static::assertSame('test IN (1, 2, 3)', $exp->compile());
    }

    /**
     * @test
     */
    public function itWillReturnAsciFunction()
    {
        $exp = (new ExprBuilder(10))->asci();

        static::assertSame('ASCI(10)', $exp->compile());
    }

    /**
     * @test
     */
    public function itWillReturnCommaSeparatedArguments()
    {
        $exp = (new ExprBuilder(10, 20, 30))->field();

        static::assertSame('FIELD(10, 20, 30)', $exp->compile());
    }
}