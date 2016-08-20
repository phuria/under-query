<?php

namespace Phuria\QueryBuilder\Test\Unit;

use Phuria\QueryBuilder\Expression\EmptyExpression;
use Phuria\QueryBuilder\Expression\RawExpression;
use Phuria\QueryBuilder\ExprNormalizer;
use Phuria\QueryBuilder\Test\Helper\UnknownClass;

/**
 * @author Beniamin Jonatan Šimko <spam@simko.it>
 */
class ExprNormalizerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function itWillReturnRawExpression()
    {
        $expr = ExprNormalizer::normalizeExpression('test');

        static::assertInstanceOf(RawExpression::class, $expr);
    }

    /**
     * @test
     */
    public function itWillReturnEmptyExpression()
    {
        $expr = ExprNormalizer::normalizeExpression('');

        static::assertInstanceOf(EmptyExpression::class, $expr);
    }

    /**
     * @test
     */
    public function itWillThrowException()
    {
        static::expectException(\Exception::class);
        ExprNormalizer::normalizeExpression(new UnknownClass());
    }
}
