<?php

namespace Phuria\QueryBuilder;

use Phuria\QueryBuilder\Expression\AliasExpression;
use Phuria\QueryBuilder\Expression\AscExpression;
use Phuria\QueryBuilder\Expression\Comparison as Comparison;
use Phuria\QueryBuilder\Expression\ConjunctionExpression;
use Phuria\QueryBuilder\Expression\DescExpression;
use Phuria\QueryBuilder\Expression\ExpressionInterface;
use Phuria\QueryBuilder\Expression\Func as Func;
use Phuria\QueryBuilder\Expression\InExpression;
use Phuria\QueryBuilder\Expression\UsingExpression;

/**
 * @author Beniamin Jonatan Šimko <spam@simko.it>
 */
class ExprBuilder implements ExpressionInterface
{
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
     * @return ExpressionInterface
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
        return new self(new DescExpression($this->wrappedExpression));
    }

    /**
     * @return ExprBuilder
     */
    public function asc()
    {
        return new self(new AscExpression($this->wrappedExpression));
    }

    /**
     * @param string $connector
     * @param mixed  $expression
     *
     * @return ExprBuilder
     */
    public function conjunction($connector, $expression)
    {
        $expression = ExprNormalizer::normalizeExpression($expression);

        return new self(new ConjunctionExpression($this, $connector, $expression));
    }

    ###############################
    ### COMPARISION EXPRESSIONS ###
    ###############################

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

        return new self(new Comparison\Between($this->wrappedExpression, $from, $to));
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
        return new self(new Comparison\IsNull($this->wrappedExpression));
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

        return new self(new Comparison\NotBetween($this->wrappedExpression, $from, $to));
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

    ##############################
    ### ARITHMETIC EXPRESSIONS ###
    ##############################

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

    #################
    ### FUNCTIONS ###
    #################

    /**
     * @return ExprBuilder
     */
    public function asci()
    {
        return new self(new Func\Asci($this->wrappedExpression));
    }

    /**
     * @return ExprBuilder
     */
    public function bin()
    {
        return new self(new Func\Bin($this->wrappedExpression));
    }

    /**
     * @return ExprBuilder
     */
    public function bitLength()
    {
        return new self(new Func\BitLength($this->wrappedExpression));
    }

    /**
     * @return ExprBuilder
     */
    public function char()
    {
        return new self(new Func\Char($this->wrappedExpression));
    }

    /**
     * @return ExprBuilder
     */
    public function coalesce()
    {
        return new self(new Func\Coalesce($this->wrappedExpression));
    }

    /**
     * @return ExprBuilder
     */
    public function concat()
    {
        return new self(new Func\Concat($this->wrappedExpression));
    }

    /**
     * @return ExprBuilder
     */
    public function concatWs()
    {
        return new self(new Func\Concat($this->wrappedExpression));
    }

    /**
     * @return ExprBuilder
     */
    public function elt()
    {
        return new self(new Func\Elt($this->wrappedExpression));
    }

    /**
     * @return ExprBuilder
     */
    public function exportSet()
    {
        return new self(new Func\ExportSet($this->wrappedExpression));
    }

    /**
     * @return ExprBuilder
     */
    public function field()
    {
        return new self(new Func\Field($this->wrappedExpression));
    }

    /**
     * @param mixed $expression
     *
     * @return ExprBuilder
     */
    public function ifNull($expression)
    {
        $expression = ExprNormalizer::normalizeExpression($expression);

        return new self(new Func\IfNull($this->wrappedExpression, $expression));
    }

    /**
     * @return ExprBuilder
     */
    public function max()
    {
        return new self(new Func\Max($this->wrappedExpression));
    }

    /**
     * @return ExprBuilder
     */
    public function sum()
    {
        return new self(new Func\Sum($this->wrappedExpression));
    }

    /**
     * @return ExprBuilder
     */
    public function year()
    {
        return new self(new Func\Year($this->wrappedExpression));
    }
}