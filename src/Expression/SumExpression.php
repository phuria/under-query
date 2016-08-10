<?php

namespace Phuria\QueryBuilder\Expression;

/**
 * @author Beniamin Jonatan Šimko <spam@simko.it>
 */
class SumExpression implements ExpressionInterface
{
    /**
     * @var mixed $wrappedExpression
     */
    private $wrappedExpression;

    /**
     * @param mixed $expression
     */
    public function __construct($expression)
    {
        $this->wrappedExpression = $expression;
    }

    /**
     * @inheritdoc
     */
    public function compile()
    {

    }
}