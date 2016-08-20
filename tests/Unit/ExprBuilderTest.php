<?php

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

    public function testCharUsingUtf8()
    {
        $using = (new ExprBuilder('utf8'))->using();
        $exp = (new ExprBuilder(10, 20, 30, $using))->char();

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
}