<?php

namespace Phuria\QueryBuilder;

use Phuria\QueryBuilder\Expression\ExpressionInterface;

/**
 * @author Beniamin Jonatan Šimko <spam@simko.it>
 */
class ExprBuilder implements ExpressionInterface
{
    /**
     * @var mixed $wrappedExpression
     */
    private $wrappedExpression;

    /**
     * @param mixed $wrappedExpression
     */
    public function __construct($wrappedExpression)
    {
        $this->wrappedExpression = $wrappedExpression;
    }

    /**
     * @inheritdoc
     */
    public function compile()
    {
        if ($this->wrappedExpression instanceof ExpressionInterface) {
            return $this->wrappedExpression->compile();
        }

        return $this->wrappedExpression;
    }

    public function sum()
    {
        return 'SUM(1)';
    }
}