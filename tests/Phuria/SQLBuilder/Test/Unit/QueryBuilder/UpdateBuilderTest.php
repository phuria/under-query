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

use Phuria\SQLBuilder\QueryBuilder;
use Phuria\SQLBuilder\QueryBuilder\UpdateBuilder;

/**
 * @author Beniamin Jonatan Šimko <spam@simko.it>
 */
class UpdateBuilderTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @return UpdateBuilder
     */
    private function createUpdateBuilder()
    {
        return (new QueryBuilder())->update();
    }

    /**
     * @test
     */
    public function updateWithSetClause()
    {
        $qb = $this->createUpdateBuilder();

        $exampleTable = $qb->update('example');
        $qb->addSet("{$exampleTable->column('name')} = NULL");

        $expectedSQL = 'UPDATE example SET example.name = NULL';
        static::assertSame($expectedSQL, $qb->buildSQL());

        $qb->addSet("{$exampleTable->column('value')} = 10");

        $expectedSQL .= ', example.value = 10';
        static::assertSame($expectedSQL, $qb->buildSQL());
    }

    /**
     * @test
     */
    public function updateWithWhereClause()
    {
        $qb = $this->createUpdateBuilder();

        $rootTable = $qb->update('example');
        $qb->addSet("{$rootTable->column('name')} = NULL");
        $qb->andWhere("{$rootTable->column('id')} = 1");

        static::assertSame('UPDATE example SET example.name = NULL WHERE example.id = 1', $qb->buildSQL());
    }

    /**
     * @test
     */
    public function updateWithOrderByAndLimit()
    {
        $qb = $this->createUpdateBuilder();

        $rootTable = $qb->update('example');
        $qb->addSet("{$rootTable->column('salary')} = 100");
        $qb->addOrderBy("{$rootTable->column('name')} DESC");
        $qb->setLimit('1');

        static::assertSame('UPDATE example SET example.salary = 100 ORDER BY example.name DESC LIMIT 1', $qb->buildSQL());
    }

    /**
     * @test
     */
    public function updateIgnore()
    {
        $qb = $this->createUpdateBuilder();

        $qb->setIgnore(true);
        $qb->update('example');
        $qb->addSet('name = "test"');

        static::assertSame('UPDATE IGNORE example SET name = "test"', $qb->buildSQL());
    }
}
