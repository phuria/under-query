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

use Phuria\SQLBuilder\Table\UnknownTable;
use Phuria\SQLBuilder\Test\TestCase\QueryBuilderTrait;

/**
 * @author Beniamin Jonatan Šimko <spam@simko.it>
 */
class UnknownTableTest extends \PHPUnit_Framework_TestCase
{
    use QueryBuilderTrait;

    /**
     * @test
     * @covers \Phuria\SQLBuilder\Table\UnknownTable
     */
    public function itHaveOwnTableName()
    {
        $table = new UnknownTable(static::phuriaSQL()->createSelect());

        $table->setTableName('test');
        static::assertSame('test', $table->getTableName());
    }
}
