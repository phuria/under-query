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
class UpdateBuilderTest extends \PHPUnit_Framework_TestCase
{
    use UnderQueryTrait;

    /**
     * @test
     * @covers \Phuria\UnderQuery\QueryBuilder\UpdateBuilder
     */
    public function itCanHaveIgnoreHint()
    {
        $qb = static::underQuery()->createUpdate();

        static::assertFalse($qb->isIgnore());
        $qb->setIgnore(true);
        static::assertTrue($qb->isIgnore());
    }

    /**
     * @test
     * @covers \Phuria\UnderQuery\QueryBuilder\UpdateBuilder
     */
    public function itCanHaveMultipleRootTables()
    {
        $qb = static::underQuery()->createUpdate();

        static::assertCount(0, $qb->getRootTables());
        $qb->update('foo');
        static::assertCount(1, $qb->getRootTables());
        $qb->addUpdate('boo');
        static::assertCount(2, $qb->getRootTables());
    }
}
