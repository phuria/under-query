<?php

namespace Phuria\QueryBuilder\Expression\Comparison;

use Phuria\QueryBuilder\Expression\ExpressionInterface;

/**
 * @author Beniamin Jonatan Šimko <spam@simko.it>
 */
class IsNull implements ExpressionInterface
{
    /**
     * @var ExpressionInterface $wrappedExpression
     */
    private $wrappedExpression;

    /**
     * @param ExpressionInterface $expression
     */
    public function __construct(ExpressionInterface $expression)
    {
        $this->wrappedExpression = $expression;
    }

    /**
     * @inheritdoc
     */
    public function compile()
    {
        return $this->wrappedExpression->compile() . ' IS NULL';
    }
}