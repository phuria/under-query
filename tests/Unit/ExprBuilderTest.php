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
        /** @var ExprBuilder $exp */
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
        /** @var ExprBuilder $exp */
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
}