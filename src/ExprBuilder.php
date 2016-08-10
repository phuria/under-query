<?php

namespace Phuria\QueryBuilder;

use Phuria\QueryBuilder\Expression\ExpressionInterface;
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
     * @return ExpressionInterface
     */
    public function sum()
    {
        return new self(new SumExpression($this->wrappedExpression));
    }
}