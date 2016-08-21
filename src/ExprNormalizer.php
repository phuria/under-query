<?php

/**
 * This file is part of Phuria SQL Builder package.
 *
 * Copyright (c) 2016 Beniamin Jonatan Šimko
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Phuria\QueryBuilder;

use Phuria\QueryBuilder\Expression\EmptyExpression;
use Phuria\QueryBuilder\Expression\ExpressionCollection;
use Phuria\QueryBuilder\Expression\ExpressionInterface;
use Phuria\QueryBuilder\Expression\RawExpression;

/**
 * @author Beniamin Jonatan Šimko <spam@simko.it>
 */
class ExprNormalizer
{
    /**
     * @param mixed $expression
     *
     * @return ExpressionInterface
     */
    public static function normalizeExpression($expression)
    {
        switch (true) {
            case $expression instanceof ExpressionInterface:
                return $expression;
            case is_array($expression):
                return static::normalizeArray($expression);
            case '' === $expression || null === $expression:
                return new EmptyExpression();
            case is_scalar($expression):
                return new RawExpression($expression);
        }

        throw new \InvalidArgumentException('Invalid argument.');
    }

    /**
     * @param array $expressions
     *
     * @return ExpressionInterface
     */
    public static function normalizeArray(array $expressions)
    {
        $normalized = [];

        foreach ($expressions as $exp) {
            $normalized[] = static::normalizeExpression($exp);
        }

        switch (count($normalized)) {
            case 0:
                return new EmptyExpression();
            case 1:
                return $normalized[0];
        }

        return new ExpressionCollection($normalized);
    }
}