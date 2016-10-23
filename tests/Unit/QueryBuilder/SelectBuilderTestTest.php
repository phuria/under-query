<?php

/**
 * This file is part of Phuria SQL Builder package.
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
class SelectBuilderTestTest extends \PHPUnit_Framework_TestCase
{
    use UnderQueryTrait;

    /**
     * @test
     * @covers \Phuria\UnderQuery\QueryBuilder\SelectBuilder
     */
    public function itCanAddSelect()
    {
        $qb = static::underQuery()->createSelect();

        static::assertCount(0, $qb->getSelectClauses());

        $qb->addSelect('10', '20');

        static::assertSame(['10', '20'], $qb->getSelectClauses());

        $qb->addSelect('5');

        static::assertSame(['10', '20', '5'], $qb->getSelectClauses());
    }
}
