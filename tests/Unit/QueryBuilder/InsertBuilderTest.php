<?php

/**
 * This file is part of UnderQuery package.
 *
 * Copyright (c) 2016 Beniamin Jonatan Šimko
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Phuria\UnderQuery\Tests\Unit\QueryBuilder;

use Phuria\UnderQuery\Tests\TestCase\UnderQueryTrait;

/**
 * @author Beniamin Jonatan Šimko <spam@simko.it>
 */
class InsertBuilderTest extends \PHPUnit_Framework_TestCase
{
    use UnderQueryTrait;

    /**
     * @test
     * @covers \Phuria\UnderQuery\QueryBuilder\InsertBuilder
     */
    public function itCanSetValues()
    {
        $qb = static::underQuery()->createInsert();

        static::assertEmpty($qb->getValues());

        $qb->addValues([10, 20, 30]);

        static::assertCount(1, $qb->getValues());
        static::assertCount(3, $qb->getValues()[0]);

        $qb->addValues([10, 20, 30]);

        static::assertCount(2, $qb->getValues());
    }
}
