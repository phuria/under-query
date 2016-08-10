<?php

namespace Phuria\QueryBuilder\Expression\Func;

/**
 * @author Beniamin Jonatan Šimko <spam@simko.it>
 */
class Max extends AbstractFuncExpression
{
    /**
     * @inheritdoc
     */
    public function getName()
    {
        return 'MAX';
    }
}