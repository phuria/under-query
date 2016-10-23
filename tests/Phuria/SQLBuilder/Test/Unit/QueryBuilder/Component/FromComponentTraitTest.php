<?php

/**
 * This file is part of Phuria SQL Builder package.
 *
 * Copyright (c) 2016 Beniamin Jonatan Šimko
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Phuria\SQLBuilder\Test\Unit\QueryBuilder\Component;

use Phuria\SQLBuilder\Test\TestCase\QueryBuilderTrait;

/**
 * @author Beniamin Jonatan Šimko <spam@simko.it>
 */
class FromComponentTraitTest extends \PHPUnit_Framework_TestCase
{
    use QueryBuilderTrait;

    /**
     * @test
     * @covers \Phuria\SQLBuilder\QueryBuilder\Component\FromComponentTrait
     */
    public function itShouldHaveMultipleFrom()
    {
        $qb = static::phuriaSQL()->createDelete();

        $qb->from('a');
        $qb->addFrom('b');
        $qb->addFrom('c');

        static::assertCount(3, $qb->getRootTables());
    }
}
