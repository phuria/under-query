<?php

namespace Phuria\QueryBuilder\Expression\Comparison;

use Phuria\QueryBuilder\Expression\AbstractOperatorExpression;

/**
 * @author Beniamin Jonatan Šimko <spam@simko.it>
 */
class Eq extends AbstractOperatorExpression
{
    /**
     * @return string
     */
    public function getOperator()
    {
        return '=';
    }
}