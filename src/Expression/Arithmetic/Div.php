<?php

namespace Phuria\QueryBuilder\Expression\Arithmetic;

/**
 * @author Beniamin Jonatan Šimko <spam@simko.it>
 */
class Div extends AbstractArithmeticExpression
{
    /**
     * @inheritdoc
     */
    public function getOperator()
    {
        return 'DIV';
    }
}