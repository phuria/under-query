<?php

namespace Phuria\QueryBuilder\Expression\Arithmetic;

use Phuria\QueryBuilder\Expression\AbstractOperatorExpression;

/**
 * @author Beniamin Jonatan Šimko <spam@simko.it>
 */
class Modulo extends AbstractOperatorExpression
{
    /**
     * @inheritdoc
     */
    public function getOperator()
    {
        return 'MOD';
    }
}