<?php

namespace Phuria\QueryBuilder;

use Phuria\QueryBuilder\Expression\AddExpression;
use Phuria\QueryBuilder\Expression\AliasExpression;
use Phuria\QueryBuilder\Expression\EmptyExpression;
use Phuria\QueryBuilder\Expression\ExpressionInterface;
use Phuria\QueryBuilder\Expression\Func as Func;
use Phuria\QueryBuilder\Expression\ImplodeExpression;
use Phuria\QueryBuilder\Expression\RawExpression;
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
        $this->wrappedExpression = static::normalizeExpression(func_get_args());
    }
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

        if (is_array($expression) && 1 === count($expression)) {
            return static::normalizeExpression($expression[0]);
        }

        if (is_array($expression)) {
            $normalized = [];

            foreach ($expression as $exp) {
                $normalized[] = static::normalizeExpression($exp);
            }

            return new ImplodeExpression($normalized);
        }

        if ('' === $expression || null === $expression) {
            return new EmptyExpression();
        }

        return new RawExpression($expression);
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
        $alias = static::normalizeExpression($alias);

        return new self(new AliasExpression($this->wrappedExpression, $alias));
    }

    /**
     * @param mixed $right
     *
     * @return ExprBuilder
     */
    public function add($right)
    {
        $right = static::normalizeExpression($right);

        return new self(new AddExpression($this->wrappedExpression, $right));
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
     * @param mixed $expression
     *
     * @return ExprBuilder
     */
    public function ifNull($expression)
    {
        $expression = static::normalizeExpression($expression);

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
    public function sumNullable()
    {
        return $this->ifNull('0')->sum();
    }
}