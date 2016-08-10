<?php

namespace Phuria\QueryBuilder\Expression\Comparison;

use Phuria\QueryBuilder\Expression\ExpressionInterface;

/**
 * @author Beniamin Jonatan Šimko <spam@simko.it>
 */
class Between implements ExpressionInterface
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
        return $this->wrappedExpression->compile() . ' BETWEEN ' . $this->from->compile() . ' AND ' . $this->to->compile();
    }
}