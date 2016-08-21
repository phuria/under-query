<?php

/**
 * This file is part of Phuria SQL Builder package.
 *
 * Copyright (c) 2016 Beniamin Jonatan Šimko
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Phuria\QueryBuilder\Test\Unit\Expression;

use Phuria\QueryBuilder\ExprBuilder;
use Phuria\QueryBuilder\Expression\ExpressionCollection;

/**
 * @author Beniamin Jonatan Šimko <spam@simko.it>
 */
class ExpressionCollectionTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function itWillBeEmpty()
    {
        $expr = new ExpressionCollection();

        static::assertTrue($expr->isEmpty());
    }

    /**
     * @test
     */
    public function itWillNotBeEmpty()
    {
        $expr = new ExpressionCollection([
            (new ExprBuilder('1'))->exportSet()
        ]);

        static::assertFalse($expr->isEmpty());
    }
}