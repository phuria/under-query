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
}