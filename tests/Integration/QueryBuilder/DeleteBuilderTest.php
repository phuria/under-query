<?php

/**
 * This file is part of Phuria SQL Builder package.
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
class DeleteBuilderTest extends \PHPUnit_Framework_TestCase
{
    use UnderQueryTrait;

    /**
     * @test
     * @coversNothing
     */
    public function simpleDelete()
    {
        $qb = static::underQuery()->createDelete();

        $table = $qb->from('example');
        $qb->andWhere("{$table->column('name')} = 'Foo'");

        static::assertSame('DELETE FROM example WHERE example.name = \'Foo\'', $qb->buildSQL());
    }

    /**
     * @test
     * @coversNothing
     */
    public function multipleTableDelete()
    {
        $qb = static::underQuery()->createDelete();

        $qb->from('user', 'u');
        $qb->innerJoin('contact', 'c', 'u.id = c.user_id');
        $qb->addDelete('u');
        $qb->addDelete('c');
        $qb->andWhere('u.id = 1');

        $expectedSQL = 'DELETE u, c FROM user AS u INNER JOIN contact AS c ON u.id = c.user_id WHERE u.id = 1';
        static::assertSame($expectedSQL, $qb->buildSQL());

        $qb = static::underQuery()->createDelete();

        $userTable = $qb->from('user', 'u');
        $contactTable = $qb->innerJoin('contact', 'c', 'u.id = c.user_id');
        $qb->addDelete($userTable, $contactTable);
        $qb->andWhere('u.id = 1');

        static::assertSame($expectedSQL, $qb->buildSQL());
    }

    /**
     * @test
     * @coversNothing
     */
    public function deleteWithOrderByAndLimit()
    {
        $qb = static::underQuery()->createDelete();

        $qb->from('example');
        $qb->addOrderBy('name DESC');
        $qb->setLimit(10);

        static::assertSame('DELETE FROM example ORDER BY name DESC LIMIT 10', $qb->buildSQL());
    }
}
