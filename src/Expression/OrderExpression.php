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
class OrderExpression implements ExpressionInterface
{
    const ORDER_ASC = 'ASC';
    const ORDER_DESC = 'DESC';

    /**
     * @var ExpressionInterface $wrappedExpression
     */
    private $wrappedExpression;

    /**
     * @var string $order
     */
    private $order;

    /**
     * @param ExpressionInterface $expression
     * @param string              $order
     */
    public function __construct(ExpressionInterface $expression, $order)
    {
        $this->wrappedExpression = $expression;
        $this->order = $order;
    }

    /**
     * @inheritdoc
     */
    public function compile()
    {
        return $this->wrappedExpression->compile() . ' ' . $this->order;
    }
}