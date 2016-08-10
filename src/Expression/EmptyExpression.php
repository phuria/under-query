<?php

namespace Phuria\QueryBuilder\Expression;

/**
 * @author Beniamin Jonatan Šimko <spam@simko.it>
 */
class EmptyExpression implements ExpressionInterface
{
    /**
     * @return string
     */
    public function compile()
    {
        return '';
    }
}