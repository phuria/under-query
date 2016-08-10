<?php

namespace Phuria\QueryBuilder\Expression\Comparison;

use Phuria\QueryBuilder\Expression\AbstractOperatorExpression;

/**
 * @author Beniamin Jonatan Šimko <spam@simko.it>
 */
class Lt extends AbstractOperatorExpression
{
    /**
     * @return string
     */
    public function getOperator()
    {
        return '<';
    }
}