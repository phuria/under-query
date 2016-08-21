<?php

/**
 * This file is part of Phuria SQL Builder package.
 *
 * Copyright (c) 2016 Beniamin Jonatan Šimko
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Phuria\QueryBuilder\Test\Unit\Expression;

use Phuria\QueryBuilder\ExprBuilder;
use Phuria\QueryBuilder\Expression\ExpressionCollection;
use Phuria\QueryBuilder\Expression\QueryClauseExpression;

/**
 * @author Beniamin Jonatan Šimko <spam@simko.it>
 */
class QueryClauseExpressionTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function itWillNotWriteWhere()
    {
        $empty = new ExpressionCollection([], ' AND ');
        $expr = new QueryClauseExpression(QueryClauseExpression::CLAUSE_WHERE, $empty);

        static::assertSame('', $expr->compile());
    }

    /**
     * @test
     */
    public function itWillWriteWhere()
    {
        $ands = new ExpressionCollection([
            (new ExprBuilder('1'))->eq('1')
        ], ' AND ');

        $expr = new QueryClauseExpression(QueryClauseExpression::CLAUSE_WHERE, $ands);

        static::assertSame('WHERE 1 = 1', $expr->compile());
    }

}