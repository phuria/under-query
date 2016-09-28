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
use Phuria\SQLBuilder\QueryBuilder\InsertSelectBuilder;
use Phuria\SQLBuilder\QueryBuilder\SelectBuilder;

/**
 * @author Beniamin Jonatan Šimko <spam@simko.it>
 */
class InsertSelectBuilderTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @return SelectBuilder
     */
    private function createSelectBuilder()
    {
        return (new QueryBuilder())->select();
    }

    /**
     * @return InsertSelectBuilder
     */
    private function createInsertSelectBuilder()
    {
        return (new QueryBuilder())->insertSelect();
    }

    /**
     * @test
     */
    public function insertSelect()
    {
        $sourceQb = $this->createSelectBuilder();

        $sourceQb->from('transactions', 't');
        $sourceQb->addSelect('t.user_id', 'SUM(t.amount)');
        $sourceQb->addGroupBy('t.user_id');

        $targetQb = $this->createInsertSelectBuilder();
        $targetQb->into('user_summary', ['user_id', 'total_price']);
        $targetQb->selectInsert($sourceQb);

        $expectedSQL = 'INSERT INTO user_summary (user_id, total_price) ' . $sourceQb->buildSQL();
        static::assertSame($expectedSQL, $targetQb->buildSQL());
    }
}
