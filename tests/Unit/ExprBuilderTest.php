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
}