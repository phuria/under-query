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

use Phuria\SQLBuilder\QueryBuilder\InsertSelectBuilder;
use Phuria\SQLBuilder\QueryBuilder\SelectBuilder;

/**
 * @author Beniamin Jonatan Šimko <spam@simko.it>
 */
class InsertSelectBuilderTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function insertSelect()
    {
        $sourceQb = new SelectBuilder();

        $sourceQb->from('transactions', 't');
        $sourceQb->addSelect('t.user_id', 'SUM(t.amount)');
        $sourceQb->addGroupBy('t.user_id');

        $targetQb = new InsertSelectBuilder();
        $targetQb->into('user_summary', ['user_id', 'total_price']);
        $targetQb->selectInsert($sourceQb);

        $expectedSQL = 'INSERT INTO user_summary (user_id, total_price) ' . $sourceQb->buildSQL();
        static::assertSame($expectedSQL, $targetQb->buildSQL());
    }
}