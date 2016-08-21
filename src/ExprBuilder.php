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

use Phuria\QueryBuilder\Expression\AliasExpression;
use Phuria\QueryBuilder\Expression\ConjunctionExpression;
use Phuria\QueryBuilder\Expression\ExpressionInterface;
use Phuria\QueryBuilder\Expression\FunctionCallContext;
use Phuria\QueryBuilder\Expression\FunctionExpression;
use Phuria\QueryBuilder\Expression\InExpression;
use Phuria\QueryBuilder\Expression\OrderExpression;
use Phuria\QueryBuilder\Expression\UsingExpression;

/**
 * @author Beniamin Jonatan Šimko <spam@simko.it>
 */
class ExprBuilder implements ExpressionInterface
{
    use ExprBuilder\ArithmeticTrait;
    use ExprBuilder\ComparisionTrait;
    use ExprBuilder\DateTimeTrait;

    /**
     * @var ExpressionInterface $wrappedExpression
     */
    private $wrappedExpression;

    /**
     * ExprBuilder constructor.
     */
    public function __construct()
    {
        $this->wrappedExpression = ExprNormalizer::normalizeExpression(func_get_args());
    }

    /**
     * @inheritdoc
     */
    public function getWrappedExpression()
    {
        return $this->wrappedExpression;
    }

    /**
     * @inheritdoc
     */
    public function compile()
    {
        return $this->wrappedExpression->compile();
    }

    /**
     * @param mixed $alias
     *
     * @return ExprBuilder
     */
    public function alias($alias)
    {
        $alias = ExprNormalizer::normalizeExpression($alias);

        return new self(new AliasExpression($this->wrappedExpression, $alias));
    }

    /**
     * @return ExprBuilder
     */
    public function sumNullable()
    {
        return $this->ifNull('0')->sum();
    }

    /**
     * @return ExprBuilder
     */
    public function in()
    {
        $arguments = ExprNormalizer::normalizeExpression(func_get_args());

        return new self(new InExpression($this->wrappedExpression, $arguments));
    }

    /**
     * @return ExprBuilder
     */
    public function using()
    {
        return new self(new UsingExpression($this->wrappedExpression));
    }

    /**
     * @return ExprBuilder
     */
    public function desc()
    {
        return new self(new OrderExpression($this->wrappedExpression, OrderExpression::ORDER_DESC));
    }

    /**
     * @return ExprBuilder
     */
    public function asc()
    {
        return new self(new OrderExpression($this->wrappedExpression, OrderExpression::ORDER_ASC));
    }

    /**
     * @inheritdoc
     */
    public function conjunction($connector, $expression)
    {
        $expression = ExprNormalizer::normalizeExpression($expression);

        return new self(new ConjunctionExpression($this, $connector, $expression));
    }

    /**
     * @param string                   $functionName
     * @param FunctionCallContext|null $context
     *
     * @return ExprBuilder
     */
    public function func($functionName, FunctionCallContext $context = null)
    {
        return new self(new FunctionExpression($functionName, $this->wrappedExpression, $context));
    }

    #################
    ### FUNCTIONS ###
    #################

    /**
     * @return ExprBuilder
     */
    public function asci()
    {
        return $this->func(FunctionExpression::FUNC_ASCI);
    }

    /**
     * @return ExprBuilder
     */
    public function bin()
    {
        return $this->func(FunctionExpression::FUNC_BIN);
    }

    /**
     * @return ExprBuilder
     */
    public function bitLength()
    {
        return $this->func(FunctionExpression::FUNC_BIT_LENGTH);
    }

    /**
     * @param mixed $using
     *
     * @return ExprBuilder
     */
    public function char($using = null)
    {
        $context = null;

        if ($using) {
            $using = ExprNormalizer::normalizeExpression($using);
            $using = new UsingExpression($using);
            $context = new FunctionCallContext(['callHints' => [$using]]);
        }

        return $this->func(FunctionExpression::FUNC_CHAR, $context);
    }

    /**
     * @return ExprBuilder
     */
    public function coalesce()
    {
        return $this->func(FunctionExpression::FUNC_COALESCE);
    }

    /**
     * @return ExprBuilder
     */
    public function concat()
    {
        return $this->func(FunctionExpression::FUNC_CONCAT);
    }

    /**
     * @return ExprBuilder
     */
    public function concatWs()
    {
        return $this->func(FunctionExpression::FUNC_CONCAT_WS);
    }

    /**
     * @return ExprBuilder
     */
    public function elt()
    {
        return $this->func(FunctionExpression::FUNC_ELT);
    }

    /**
     * @return ExprBuilder
     */
    public function exportSet()
    {
        return $this->func(FunctionExpression::FUNC_EXPORT_SET);
    }

    /**
     * @return ExprBuilder
     */
    public function field()
    {
        return $this->func(FunctionExpression::FUNC_FIELD);
    }

    /**
     * @param mixed $expression
     *
     * @return ExprBuilder
     */
    public function ifNull($expression)
    {
        return new self(new FunctionExpression(
            FunctionExpression::FUNC_IFNULL,
            ExprNormalizer::normalizeExpression([$this->wrappedExpression, $expression])
        ));
    }

    /**
     * @return ExprBuilder
     */
    public function max()
    {
        return $this->func(FunctionExpression::FUNC_MAX);
    }

    /**
     * @return ExprBuilder
     */
    public function sum()
    {
        return $this->func(FunctionExpression::FUNC_SUM);
    }
}