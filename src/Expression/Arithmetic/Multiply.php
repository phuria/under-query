<?php

namespace Phuria\QueryBuilder\Expression\Arithmetic;

use Phuria\QueryBuilder\Expression\AbstractOperatorExpression;

/**
 * @author Beniamin Jonatan Šimko <spam@simko.it>
 */
class Multiply extends AbstractOperatorExpression
{
    /**
     * @inheritdoc
     */
    public function getOperator()
    {
        return '*';
    }
}