<?php

namespace Phuria\QueryBuilder\Expression\Arithmetic;

/**
 * @author Beniamin Jonatan Šimko <spam@simko.it>
 */
class Multiply extends AbstractArithmeticExpression
{
    /**
     * @inheritdoc
     */
    public function getOperator()
    {
        return '*';
    }
}