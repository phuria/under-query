<?php

namespace Phuria\QueryBuilder;

use Phuria\QueryBuilder\Expression\AliasExpression;
use Phuria\QueryBuilder\Expression\ExpressionInterface;
use Phuria\QueryBuilder\Expression\IfNullExpression;
use Phuria\QueryBuilder\Expression\MaxExpression;
use Phuria\QueryBuilder\Expression\SumExpression;

/**
 * @author Beniamin Jonatan Šimko <spam@simko.it>
 */
class ExprBuilder implements ExpressionInterface
{
    /**
     * @var ExpressionInterface $wrappedExpression
     */
    private $wrappedExpression;

    /**
     * @param mixed $wrappedExpression
     */
    public function __construct($wrappedExpression)
    {
        $this->wrappedExpression = Expr::normalizeExpression($wrappedExpression);
    }

    /**
     * @inheritdoc
     */
    public function compile()
    {
        return $this->wrappedExpression->compile();
    }

    /**
     * @return ExprBuilder
     */
    public function sum()
    {
        return new self(new SumExpression($this->wrappedExpression));
    }

    /**
     * @return ExprBuilder
     */
    public function max()
    {
        return new self(new MaxExpression($this->wrappedExpression));
    }

    /**
     * @param mixed $expression
     *
     * @return ExprBuilder
     */
    public function ifNull($expression)
    {
        $expression = Expr::normalizeExpression($expression);

        return new self(new IfNullExpression($this->wrappedExpression, $expression));
    }

    /**
     * @param mixed $alias
     *
     * @return ExprBuilder
     */
    public function alias($alias)
    {
        $alias = Expr::normalizeExpression($alias);

        return new self(new AliasExpression($this->wrappedExpression, $alias));
    }
}