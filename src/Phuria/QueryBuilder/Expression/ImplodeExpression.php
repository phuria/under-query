<?php

namespace Phuria\QueryBuilder\Expression;

/**
 * @author Beniamin Jonatan Šimko <spam@simko.it>
 */
class ImplodeExpression implements ExpressionInterface
{
    public function __construct(array $expressionList)
    {
        $this->expressionList();
    }

    public function compile()
    {

    }
}