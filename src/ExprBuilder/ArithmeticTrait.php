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
use Phuria\QueryBuilder\Expression\ConjunctionExpression;
use Phuria\QueryBuilder\ExprNormalizer;

/**
 * @author Beniamin Jonatan Šimko <spam@simko.it>
 */
trait ArithmeticTrait
{
    /**
     * @param $connector
     * @param $expression
     *
     * @return ExprBuilder
     */
    abstract public function conjunction($connector, $expression);

    /**
     * @param mixed $expression
     *
     * @return ExprBuilder
     */
    public function add($expression)
    {
        $expression = ExprNormalizer::normalizeExpression($expression);

        return $this->conjunction(ConjunctionExpression::SYMBOL_ADD, $expression);
    }

    /**
     * @param mixed $expression
     *
     * @return ExprBuilder
     */
    public function div($expression)
    {
        $expression = ExprNormalizer::normalizeExpression($expression);

        return $this->conjunction(ConjunctionExpression::SYMBOL_DIV, $expression);
    }

    /**
     * @param mixed $expression
     *
     * @return ExprBuilder
     */
    public function divide($expression)
    {
        $expression = ExprNormalizer::normalizeExpression($expression);

        return $this->conjunction(ConjunctionExpression::SYMBOL_DIVIDE, $expression);
    }

    /**
     * @param mixed $expression
     *
     * @return ExprBuilder
     */
    public function modulo($expression)
    {
        $expression = ExprNormalizer::normalizeExpression($expression);

        return $this->conjunction(ConjunctionExpression::SYMBOL_MODULO, $expression);
    }

    /**
     * @param mixed $expression
     *
     * @return ExprBuilder
     */
    public function multiply($expression)
    {
        $expression = ExprNormalizer::normalizeExpression($expression);

        return $this->conjunction(ConjunctionExpression::SYMBOL_MULTIPLY, $expression);
    }

    /**
     * @param mixed $expression
     *
     * @return ExprBuilder
     */
    public function subtract($expression)
    {
        $expression = ExprNormalizer::normalizeExpression($expression);

        return $this->conjunction(ConjunctionExpression::SYMBOL_SUBTRACT, $expression);
    }
}