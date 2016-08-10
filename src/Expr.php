<?php

namespace Phuria\QueryBuilder;

use Phuria\QueryBuilder\Expression\EmptyExpression;
use Phuria\QueryBuilder\Expression\ExpressionInterface;
use Phuria\QueryBuilder\Expression\ImplodeExpression;
use Phuria\QueryBuilder\Expression\RawExpression;

/**
 * @author Beniamin Jonatan Šimko <spam@simko.it>
 */
class Expr
{
    /**
     * @param mixed $expression
     *
     * @return ExpressionInterface
     */
    public static function normalizeExpression($expression)
    {
        if ($expression instanceof ExpressionInterface) {
            return $expression;
        }

        if ('' === $expression || null === $expression) {
            return new EmptyExpression();
        }

        return new RawExpression($expression);
    }

    /**
     * @return ImplodeExpression
     */
    public static function implode()
    {
        $args = func_get_args();
        $expressions = [];

        foreach ($args as $arg) {
            $expressions[] = static::normalizeExpression($arg);
        }

        return new ImplodeExpression($expressions);
    }
}