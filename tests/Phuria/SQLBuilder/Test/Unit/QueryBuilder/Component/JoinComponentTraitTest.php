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
class JoinComponentTraitTest extends \PHPUnit_Framework_TestCase
{
    use QueryBuilderTrait;

    /**
     * @test
     * @covers \Phuria\SQLBuilder\QueryBuilder\Component\JoinComponentTrait
     */
    public function itCanJoin()
    {
        $qb = static::phuriaSQL()->createDelete();

        static::assertCount(0, $qb->getJoinTables());

        $qb->join('table');
        $qb->straightJoin('table');
        $qb->leftJoin('table');
        $qb->crossJoin('table');
        $qb->rightJoin('table');
        $qb->innerJoin('table');

        static::assertCount(6, $qb->getJoinTables());
    }

    /**
     * @test
     * @covers \Phuria\SQLBuilder\QueryBuilder\Component\JoinComponentTrait
     */
    public function itCanJoinWithAlias()
    {
        $qb = static::phuriaSQL()->createDelete();

        $table = $qb->join('table', 'a');

        static::assertSame('table', $table->getTableName());
        static::assertSame('a', $table->getAlias());
    }

    /**
     * @test
     * @covers \Phuria\SQLBuilder\QueryBuilder\Component\JoinComponentTrait
     */
    public function itCanJoinWithOnClause()
    {
        $qb = static::phuriaSQL()->createSelect();

        $table = $qb->join('table', null, '1=1');

        static::assertSame('table', $table->getTableName());
        static::assertNull($table->getAlias());
        static::assertSame('1=1', $table->getJoinOn());
    }
}
