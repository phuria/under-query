<?php

/**
 * This file is part of Phuria SQL Builder package.
 *
 * Copyright (c) 2016 Beniamin Jonatan Šimko
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Phuria\SQLBuilder\Test\Unit\Table;

use Phuria\SQLBuilder\Table\SubQueryTable;
use Phuria\SQLBuilder\Test\TestCase\QueryBuilderTrait;

/**
 * @author Beniamin Jonatan Šimko <spam@simko.it>
 */
class SubQueryTableTest extends \PHPUnit_Framework_TestCase
{
    use QueryBuilderTrait;

    /**
     * @test
     * @covers \Phuria\SQLBuilder\Table\SubQueryTable
     */
    public function itCreateTableFromQuery()
    {
        $rootQuery = static::phuriaSQL()->createSelect();
        $subQuery = static::phuriaSQL()->createSelect();

        $table = new SubQueryTable($subQuery, $rootQuery);

        static::assertSame($table->getWrappedQueryBuilder(), $subQuery);
        static::assertTrue(is_string($table->getTableName()));
    }
}
