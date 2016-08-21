<?php

/**
 * This file is part of Phuria SQL Builder package.
 *
 * Copyright (c) 2016 Beniamin Jonatan Šimko
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Phuria\QueryBuilder\ExprBuilder;

use Phuria\QueryBuilder\ExprBuilder;
use Phuria\QueryBuilder\Expression\Comparison\Between;
use Phuria\QueryBuilder\Expression\Comparison\IsNull;
use Phuria\QueryBuilder\Expression\Comparison\NotBetween;
use Phuria\QueryBuilder\Expression\ConjunctionExpression;
use Phuria\QueryBuilder\Expression\ExpressionInterface;
use Phuria\QueryBuilder\ExprNormalizer;

/**
 * @author Beniamin Jonatan Šimko <spam@simko.it>
 */
trait ComparisionTrait
{
    /**
     * @param $connector
     * @param $expression
     *
     * @return ExprBuilder
     */
    abstract public function conjunction($connector, $expression);

    /**
     * @return ExpressionInterface
     */
    abstract public function getWrappedExpression();


    /**
     * @param mixed $from
     * @param mixed $to
     *
     * @return ExprBuilder
     */
    public function between($from, $to)
    {
        $from = ExprNormalizer::normalizeExpression($from);
        $to = ExprNormalizer::normalizeExpression($to);

        return new ExprBuilder(new Between($this->getWrappedExpression(), $from, $to));
    }

    /**
     * @param mixed $expression
     *
     * @return ExprBuilder
     */
    public function eq($expression)
    {
        $expression = ExprNormalizer::normalizeExpression($expression);

        return $this->conjunction(ConjunctionExpression::SYMBOL_EQ, $expression);
    }

    /**
     * @param mixed $expression
     *
     * @return ExprBuilder
     */
    public function gt($expression)
    {
        $expression = ExprNormalizer::normalizeExpression($expression);

        return $this->conjunction(ConjunctionExpression::SYMBOL_GT, $expression);
    }

    /**
     * @param mixed $expression
     *
     * @return ExprBuilder
     */
    public function gte($expression)
    {
        $expression = ExprNormalizer::normalizeExpression($expression);

        return $this->conjunction(ConjunctionExpression::SYMBOL_GTE, $expression);
    }

    /**
     * @return ExprBuilder
     */
    public function isNull()
    {
        return new ExprBuilder(new IsNull($this->getWrappedExpression()));
    }

    /**
     * @param mixed $expression
     *
     * @return ExprBuilder
     */
    public function lt($expression)
    {
        $expression = ExprNormalizer::normalizeExpression($expression);

        return $this->conjunction(ConjunctionExpression::SYMBOL_LT, $expression);
    }

    /**
     * @param mixed $expression
     *
     * @return ExprBuilder
     */
    public function lte($expression)
    {
        $expression = ExprNormalizer::normalizeExpression($expression);

        return $this->conjunction(ConjunctionExpression::SYMBOL_LTE, $expression);
    }

    /**
     * @param mixed $expression
     *
     * @return ExprBuilder
     */
    public function neq($expression)
    {
        $expression = ExprNormalizer::normalizeExpression($expression);

        return $this->conjunction(ConjunctionExpression::SYMBOL_NEQ, $expression);
    }

    /**
     * @param mixed $from
     * @param mixed $to
     *
     * @return ExprBuilder
     */
    public function notBetween($from, $to)
    {
        $from = ExprNormalizer::normalizeExpression($from);
        $to = ExprNormalizer::normalizeExpression($to);

        return new ExprBuilder(new NotBetween($this->getWrappedExpression(), $from, $to));
    }

    /**
     * @param mixed $expression
     *
     * @return ExprBuilder
     */
    public function nullEq($expression)
    {
        $expression = ExprNormalizer::normalizeExpression($expression);

        return $this->conjunction(ConjunctionExpression::SYMBOL_NULL_EQ, $expression);
    }
}