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
