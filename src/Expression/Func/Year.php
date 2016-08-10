<?php

namespace Phuria\QueryBuilder\Expression\Func;

/**
 * @author Beniamin Jonatan Šimko <spam@simko.it>
 */
class Year extends AbstractFuncExpression
{
    /**
     * @inheritdoc
     */
    public function getName()
    {
        return 'YEAR';
    }
}