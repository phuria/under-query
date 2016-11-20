<?php

/**
 * This file is part of UnderQuery package.
 *
 * Copyright (c) 2016 Beniamin Jonatan Šimko
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Phuria\UnderQuery\Tests\Unit\QueryBuilder\Clause;

use Phuria\UnderQuery\Language\Expression\RelativeClause;
use Phuria\UnderQuery\Tests\TestCase\UnderQueryTrait;

/**
 * @author Beniamin Jonatan Šimko <spam@simko.it>
 */
class JoinTraitTest extends \PHPUnit_Framework_TestCase
{
    use UnderQueryTrait;

    /**
     * @test
     * @covers \Phuria\UnderQuery\QueryBuilder\Clause\JoinTrait
     */
    public function itCanJoin()
    {
        $qb = static::underQuery()->createDelete();

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
     * @covers \Phuria\UnderQuery\QueryBuilder\Clause\JoinTrait
     */
    public function itCanJoinWithAlias()
    {
        $qb = static::underQuery()->createDelete();

        $table = $qb->join('table', 'a');

        static::assertInternalType('string', $table->getTableName());
        static::assertSame('table', $table->getTableName());
        static::assertSame('a', $table->getAlias());
    }

    /**
     * @test
     * @covers \Phuria\UnderQuery\QueryBuilder\Clause\JoinTrait
     */
    public function itCanJoinWithOnClause()
    {
        $qb = static::underQuery()->createSelect();

        $table = $qb->join('table', null, '1=1');

        static::assertSame('table', $table->getTableName());
        static::assertNull($table->getAlias());

        /** @var RelativeClause $relativeOn */
        $relativeOn = $table->getJoinMetadata()->getJoinOn();
        static::assertInstanceOf(RelativeClause::class, $relativeOn);
        static::assertSame('1=1', $relativeOn->getClause());
    }
}
