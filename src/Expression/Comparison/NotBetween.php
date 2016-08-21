<?php

/**
 * This file is part of Phuria SQL Builder package.
 *
 * Copyright (c) 2016 Beniamin Jonatan Šimko
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Phuria\QueryBuilder\Expression\Comparison;

use Phuria\QueryBuilder\Expression\ExpressionInterface;

/**
 * @author Beniamin Jonatan Šimko <spam@simko.it>
 */
class NotBetween implements ExpressionInterface
{
    /**
     * @var ExpressionInterface $wrappedExpression
     */
    private $wrappedExpression;

    /**
     * @var ExpressionInterface $wrappedExpression
     */
    private $from;

    /**
     * @var ExpressionInterface $wrappedExpression
     */
    private $to;

    /**
     * @param ExpressionInterface $expression
     * @param ExpressionInterface $from
     * @param ExpressionInterface $to
     */
    public function __construct(ExpressionInterface $expression, ExpressionInterface $from, ExpressionInterface $to)
    {
        $this->wrappedExpression = $expression;
        $this->from = $from;
        $this->to = $to;
    }

    /**
     * @inheritdoc
     */
    public function compile()
    {
        return $this->wrappedExpression->compile() . ' NOT BETWEEN ' . $this->from->compile() . ' AND ' . $this->to->compile();
    }
}