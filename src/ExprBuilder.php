<?php

namespace Phuria\QueryBuilder;

use Phuria\QueryBuilder\Expression\AliasExpression;
use Phuria\QueryBuilder\Expression\EmptyExpression;
use Phuria\QueryBuilder\Expression\ExpressionInterface;
use Phuria\QueryBuilder\Expression\IfNullExpression;
use Phuria\QueryBuilder\Expression\ImplodeExpression;
use Phuria\QueryBuilder\Expression\MaxExpression;
use Phuria\QueryBuilder\Expression\RawExpression;
use Phuria\QueryBuilder\Expression\SumExpression;

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
     * @inheritdoc
     */
    public function compile()
    {
        return $this->wrappedExpression->compile();
    }

    /**
     * @return ExprBuilder
     */
    public function sum()
    {
        return new self(new SumExpression($this->wrappedExpression));
    }

    /**
     * @return ExprBuilder
     */
    public function max()
    {
        return new self(new MaxExpression($this->wrappedExpression));
    }

    /**
     * @param mixed $expression
     *
     * @return ExprBuilder
     */
    public function ifNull($expression)
    {
        $expression = static::normalizeExpression($expression);

        return new self(new IfNullExpression($this->wrappedExpression, $expression));
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
}