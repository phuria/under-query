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

use Phuria\SQLBuilder\QueryBuilder\InsertBuilder;

/**
 * @author Beniamin Jonatan Šimko <spam@simko.it>
 */
class InsertBuilderTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function simpleInsert()
    {
        $qb = new InsertBuilder();

        $qb->insert('example');
        $qb->setColumns(['id', 'name']);
        $qb->addValues([1, 'foo']);
        $qb->addValues([2, 'boo']);

        static::assertSame('INSERT example (id, name) VALUES (1, "foo"), (2, "boo")', $qb->buildSQL());
    }
}
