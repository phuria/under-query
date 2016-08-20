<?php

namespace Phuria\QueryBuilder\Test\Unit;

use Phuria\QueryBuilder\Expression\RawExpression;
use Phuria\QueryBuilder\ExprNormalizer;

/**
 * @author Beniamin Jonatan Šimko <spam@simko.it>
 */
class ExprNormalizerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function itReturnRawExpression()
    {
        $expr = ExprNormalizer::normalizeExpression('test');

        static::assertInstanceOf(RawExpression::class, $expr);
    }
}
