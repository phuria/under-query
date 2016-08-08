<?php

namespace Phuria\QueryBuilder;

use Phuria\QueryBuilder\Expression\ImplodeExpression;
use Phuria\QueryBuilder\Reference\ColumnReference;

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
        $expressions = [];

        foreach ($args as $arg) {
            if ($arg instanceof ColumnReference) {
                $arg = $arg->toExpression();
            }

            $expressions[] = $arg;
        }

        return new ImplodeExpression($expressions);
    }
}