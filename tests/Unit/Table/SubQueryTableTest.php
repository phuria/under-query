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

use Phuria\UnderQuery\Table\SubQueryTable;
use Phuria\UnderQuery\Tests\TestCase\UnderQueryTrait;

/**
 * @author Beniamin Jonatan Šimko <spam@simko.it>
 */
class SubQueryTableTest extends \PHPUnit_Framework_TestCase
{
    use UnderQueryTrait;

    /**
     * @test
     * @covers \Phuria\UnderQuery\Table\SubQueryTable
     */
    public function itCreateTableFromQuery()
    {
        $rootQuery = static::underQuery()->createSelect();
        $subQuery = static::underQuery()->createSelect();

        $table = new SubQueryTable($subQuery, $rootQuery);

        static::assertSame($table->getWrappedQueryBuilder(), $subQuery);
        static::assertTrue(is_string($table->getTableName()));
    }
}
