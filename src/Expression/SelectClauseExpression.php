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

/**
 * @author Beniamin Jonatan Šimko <spam@simko.it>
 */
class SelectClauseExpression extends QueryClauseExpression
{
    /**
     * @var ExpressionInterface $hints
     */
    private $hints;

    /**
     * @param ExpressionInterface $hints
     * @param ExpressionInterface $expression
     * @param bool                $quietWhenEmpty
     */
    public function __construct(ExpressionInterface $hints, ExpressionInterface $expression, $quietWhenEmpty = true)
    {
        $this->hints = $hints;
        parent::__construct(static::CLAUSE_SELECT, $expression, $quietWhenEmpty);
    }

    /**
     * @inheritdoc
     */
    public function isEmpty()
    {
        $hints = $this->hints;

        if (parent::isEmpty() && $hints instanceof ExpressionCollection && $hints->isEmpty()) {
            return true;
        }

        return false;
    }

    /**
     * @inheritdoc
     */
    public function compile()
    {
        if ($this->isQuietWhenEmpty() && $this->isEmpty()) {
            return '';
        }

        return implode(' ', array_filter([
            $this->getClause(),
            $this->hints->compile(),
            $this->getWrappedExpression()->compile()
        ]));
    }
}