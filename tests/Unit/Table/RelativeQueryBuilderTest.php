<?php

/**
 * This file is part of UnderQuery package.
 *
 * Copyright (c) 2016 Beniamin Jonatan Šimko
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Phuria\UnderQuery\Tests\Unit\Table;

use Phuria\UnderQuery\QueryBuilder\Clause\SelectInterface;
use Phuria\UnderQuery\Table\DefaultTable;
use Phuria\UnderQuery\Table\RelativeQueryBuilder;
use Phuria\UnderQuery\Tests\TestCase\UnderQueryTrait;

/**
 * @author Beniamin Jonatan Šimko <spam@simko.it>
 */
class RelativeQueryBuilderTest extends \PHPUnit_Framework_TestCase
{
    use UnderQueryTrait;

    /**
     * @test
     * @covers \Phuria\UnderQuery\Table\RelativeQueryBuilder
     */
    public function itCanSelectRelative()
    {
        $table = new DefaultTable($select = self::underQuery()->createSelect());
        $relativeQb = new RelativeQueryBuilder($select, $table);

        $relativeQb->addSelect('@.column_1');
        static::assertCount(1, $relativeQb->getSelectClauses());
    }
}
