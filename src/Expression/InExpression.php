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
class InExpression implements ExpressionInterface
{
    /**
     * @var ExpressionInterface $wrappedExpression
     */
    private $wrappedExpression;

    /**
     * @var ExpressionInterface $arguments
     */
    private $arguments;

    /**
     * @param ExpressionInterface $expression
     * @param ExpressionInterface $arguments
     */
    public function __construct(ExpressionInterface $expression, ExpressionInterface $arguments)
    {
        $this->wrappedExpression = $expression;
        $this->arguments = $arguments;
    }

    /**
     * @inheritdoc
     */
    public function compile()
    {
        $expression = $this->arguments;

        if ($expression instanceof ExprBuilder) {
            $expression = $expression->getWrappedExpression();
        }

        if ($expression instanceof ExpressionCollection) {
            $expression = $expression->changeSeparator(', ');
        }

        return $this->wrappedExpression->compile() . ' IN (' . $expression->compile() . ')';
    }
}