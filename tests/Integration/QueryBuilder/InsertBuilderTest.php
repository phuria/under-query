<?php

/**
 * This file is part of UnderQuery package.
 *
 * Copyright (c) 2016 Beniamin Jonatan Šimko
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Phuria\UnderQuery\Tests\Integration\QueryBuilder;

use Phuria\UnderQuery\Tests\TestCase\UnderQueryTrait;

/**
 * @author Beniamin Jonatan Šimko <spam@simko.it>
 */
class InsertBuilderTest extends \PHPUnit_Framework_TestCase
{
    use UnderQueryTrait;

    /**
     * @test
     * @coversNothing
     */
    public function simpleInsert()
    {
        $qb = static::underQuery()->createInsert();

        $qb->into('example');
        $qb->setColumns(['id', 'name']);
        $qb->addValues([1, 'foo']);
        $qb->addValues([2, 'boo']);

        static::assertSame('INSERT INTO example (id, name) VALUES (1, "foo"), (2, "boo")', $qb->buildSQL());
    }

    /**
     * @test
     * @coversNothing
     */
    public function insertMultipleArguments()
    {
        $qb = static::underQuery()->createInsert();

        $qb->into('user', ['username', 'email']);
        $qb->addValues(['foo', 'bar']);

        static::assertSame('INSERT INTO user (username, email) VALUES ("foo", "bar")', $qb->buildSQL());
    }
}
