<?php

/**
 * This file is part of Phuria SQL Builder package.
 *
 * Copyright (c) 2016 Beniamin Jonatan Šimko
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Phuria\SQLBuilder\Test\Unit\QueryBuilder;

use Phuria\SQLBuilder\Test\TestCase\QueryBuilderTrait;

/**
 * @author Beniamin Jonatan Šimko <spam@simko.it>
 */
class DeleteBuilderTest extends \PHPUnit_Framework_TestCase
{
    use QueryBuilderTrait;

    /**
     * @test
     * @covers \Phuria\SQLBuilder\QueryBuilder\DeleteBuilder
     */
    public function itShouldHaveMultipleDelete()
    {
        $qb = static::phuriaSQL()->createDelete();

        $qb->addDelete('a', 'b');
        $qb->addDelete('c');

        static::assertSame(['a', 'b', 'c'], $qb->getDeleteClauses());
    }
}
