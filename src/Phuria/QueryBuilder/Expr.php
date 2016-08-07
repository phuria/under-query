<?php

namespace Phuria\QueryBuilder;

use Phuria\QueryBuilder\Expression\ConnectExpression;

/**
 * @author Beniamin Jonatan Šimko <spam@simko.it>
 */
class Expr
{
    /**
     * @return ConnectExpression
     */
    public static function connect()
    {
        $args = func_get_args();

        return new ConnectExpression($args);
    }
}