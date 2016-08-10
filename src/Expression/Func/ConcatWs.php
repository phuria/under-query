<?php

namespace Phuria\QueryBuilder\Expression\Func;

/**
 * @author Beniamin Jonatan Šimko <spam@simko.it>
 */
class ConcatWs extends AbstractFuncExpression
{
    /**
     * @inheritdoc
     */
    public function getName()
    {
        return 'CONCAT_WS';
    }
}