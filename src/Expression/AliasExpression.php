<?php

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