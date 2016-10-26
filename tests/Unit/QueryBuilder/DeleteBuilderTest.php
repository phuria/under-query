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
class DeleteBuilderTest extends \PHPUnit_Framework_TestCase
{
    use UnderQueryTrait;

    /**
     * @test
     * @covers \Phuria\UnderQuery\QueryBuilder\DeleteBuilder
     */
    public function itShouldHaveMultipleDelete()
    {
        $qb = static::underQuery()->createDelete();

        $qb->addDelete('a', 'b');
        $qb->addDelete('c');

        static::assertSame(['a', 'b', 'c'], $qb->getDeleteClauses());
    }
}
