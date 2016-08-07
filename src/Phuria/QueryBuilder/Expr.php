<?php

namespace Phuria\QueryBuilder;

use Phuria\QueryBuilder\Expression\ImplodeExpression;

/**
 * @author Beniamin Jonatan Šimko <spam@simko.it>
 */
class Expr
{
    /**
     * @param mixed $expr
     *
     * @return ImplodeExpression
     */
    public static function max($expr)
    {
        return static::implode('MAX(', $expr, ')');
    }

    /**
     * @return ImplodeExpression
     */
    public static function implode()
    {
        $args = func_get_args();

        return new ImplodeExpression($args);
    }
}