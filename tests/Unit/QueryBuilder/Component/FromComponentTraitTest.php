<?php

/**
 * This file is part of Phuria SQL Builder package.
 *
 * Copyright (c) 2016 Beniamin Jonatan Šimko
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Phuria\UnderQuery\Tests\Unit\QueryBuilder\Component;

use Phuria\UnderQuery\Tests\TestCase\UnderQueryTrait;

/**
 * @author Beniamin Jonatan Šimko <spam@simko.it>
 */
class FromComponentTraitTest extends \PHPUnit_Framework_TestCase
{
    use UnderQueryTrait;

    /**
     * @test
     * @covers \Phuria\UnderQuery\QueryBuilder\Component\FromComponentTrait
     */
    public function itShouldHaveMultipleFrom()
    {
        $qb = static::underQuery()->createDelete();

        $qb->from('a');
        $qb->addFrom('b');
        $qb->addFrom('c');

        static::assertCount(3, $qb->getRootTables());
    }
}
