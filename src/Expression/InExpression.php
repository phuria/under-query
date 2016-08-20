<?php

namespace Phuria\QueryBuilder\Expression;

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
        return $this->wrappedExpression->compile() . ' IN (' . $this->arguments->compile(', ') . ')';
    }
}