<?php

/**
 * This file is part of Phuria SQL Builder package.
 *
 * Copyright (c) 2016 Beniamin Jonatan Šimko
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Phuria\QueryBuilder\Expression;

use Phuria\QueryBuilder\ExprBuilder;

/**
 * @author Beniamin Jonatan Šimko <spam@simko.it>
 */
class QueryClauseExpression implements ExpressionInterface
{
    const CLAUSE_WHERE = 'WHERE';
    const CLAUSE_SELECT = 'SELECT';
    const CLAUSE_ORDER_BY = 'ORDER BY';
    const CLAUSE_SET = 'SET';
    const CLAUSE_GROUP_BY = 'GROUP BY';
    const CLAUSE_HAVING = 'HAVING';

    /**
     * @var string $clause
     */
    private $clause;

    /**
     * @var ExpressionInterface $wrappedExpression
     */
    private $wrappedExpression;

    /**
     * @var bool $quietWhenEmpty
     */
    private $quietWhenEmpty;

    /**
     * @param string              $clause
     * @param ExpressionInterface $expression
     * @param bool                $quietWhenEmpty
     */
    public function __construct($clause, ExpressionInterface $expression, $quietWhenEmpty = true)
    {
        $this->clause = $clause;
        $this->wrappedExpression = $expression;
        $this->quietWhenEmpty = $quietWhenEmpty;
    }

    /**
     * @return boolean
     */
    public function isQuietWhenEmpty()
    {
        return $this->quietWhenEmpty;
    }

    /**
     * @return bool
     */
    public function isEmpty()
    {
        $expr = $this->wrappedExpression;

        if ($expr instanceof ExprBuilder) {
            $expr = $expr->getWrappedExpression();
        }

        if ($expr instanceof EmptyExpression) {
            return true;
        }

        if ($expr instanceof ExpressionCollection && $expr->isEmpty()) {
            return true;
        }

        return false;
    }

    /**
     * @return string
     */
    public function getClause()
    {
        return $this->clause;
    }

    /**
     * @return ExpressionInterface
     */
    public function getWrappedExpression()
    {
        return $this->wrappedExpression;
    }

    /**
     * @inheritdoc
     */
    public function compile()
    {
        if ($this->isQuietWhenEmpty() && $this->isEmpty()) {
            return '';
        } else if ($this->isEmpty()) {
            return $this->clause;
        }

        return $this->clause . ' ' . $this->wrappedExpression->compile();
    }
}