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
class AliasExpression implements ExpressionInterface
{
    /**
     * @var ExpressionInterface $wrappedExpression
     */
    private $wrappedExpression;

    /**
     * @var ExpressionInterface $alias
     */
    private $alias;

    /**
     * @param ExpressionInterface $expression
     * @param ExpressionInterface $alias
     */
    public function __construct(ExpressionInterface $expression, ExpressionInterface $alias)
    {
        $this->wrappedExpression = $expression;
        $this->alias = $alias;
    }

    /**
     * @inheritdoc
     */
    public function compile()
    {
        return $this->wrappedExpression->compile() . ' AS ' . $this->alias->compile();
    }
}