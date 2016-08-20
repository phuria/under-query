<?php

namespace Phuria\QueryBuilder;

use Phuria\QueryBuilder\Expression\AliasExpression;
use Phuria\QueryBuilder\Expression\Arithmetic as Arithmetic;
use Phuria\QueryBuilder\Expression\AscExpression;
use Phuria\QueryBuilder\Expression\Comparison as Comparison;
use Phuria\QueryBuilder\Expression\DescExpression;
use Phuria\QueryBuilder\Expression\EmptyExpression;
use Phuria\QueryBuilder\Expression\ExpressionInterface;
use Phuria\QueryBuilder\Expression\Func as Func;
use Phuria\QueryBuilder\Expression\ImplodeExpression;
use Phuria\QueryBuilder\Expression\InExpression;
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

        if (is_scalar($expression)) {
            return new RawExpression($expression);
        }

        throw new \InvalidArgumentException('Invalid argument.');
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
        $arguments = static::normalizeExpression(func_get_args());

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
        $from = static::normalizeExpression($from);
        $to = static::normalizeExpression($to);

        return new self(new Comparison\Between($this->wrappedExpression, $from, $to));
    }

    /**
     * @param mixed $right
     *
     * @return ExprBuilder
     */
    public function eq($right)
    {
        $right = static::normalizeExpression($right);

        return new self(new Comparison\Eq($this->wrappedExpression, $right));
    }

    /**
     * @param mixed $right
     *
     * @return ExprBuilder
     */
    public function gt($right)
    {
        $right = static::normalizeExpression($right);

        return new self(new Comparison\Gt($this->wrappedExpression, $right));
    }

    /**
     * @param mixed $right
     *
     * @return ExprBuilder
     */
    public function gte($right)
    {
        $right = static::normalizeExpression($right);

        return new self(new Comparison\Gte($this->wrappedExpression, $right));
    }

    /**
     * @return ExprBuilder
     */
    public function isNull()
    {
        return new self(new Comparison\IsNull($this->wrappedExpression));
    }

    /**
     * @param mixed $right
     *
     * @return ExprBuilder
     */
    public function lt($right)
    {
        $right = static::normalizeExpression($right);

        return new self(new Comparison\Lt($this->wrappedExpression, $right));
    }

    /**
     * @param mixed $right
     *
     * @return ExprBuilder
     */
    public function lte($right)
    {
        $right = static::normalizeExpression($right);

        return new self(new Comparison\Lte($this->wrappedExpression, $right));
    }

    /**
     * @param mixed $right
     *
     * @return ExprBuilder
     */
    public function neq($right)
    {
        $right = static::normalizeExpression($right);

        return new self(new Comparison\Neq($this->wrappedExpression, $right));
    }

    /**
     * @param mixed $from
     * @param mixed $to
     *
     * @return ExprBuilder
     */
    public function notBetween($from, $to)
    {
        $from = static::normalizeExpression($from);
        $to = static::normalizeExpression($to);

        return new self(new Comparison\NotBetween($this->wrappedExpression, $from, $to));
    }

    /**
     * @param mixed $right
     *
     * @return ExprBuilder
     */
    public function nullEq($right)
    {
        $right = static::normalizeExpression($right);

        return new self(new Comparison\NullEq($this->wrappedExpression, $right));
    }

    ##############################
    ### ARITHMETIC EXPRESSIONS ###
    ##############################

    /**
     * @param mixed $right
     *
     * @return ExprBuilder
     */
    public function add($right)
    {
        $right = static::normalizeExpression($right);

        return new self(new Arithmetic\Add($this->wrappedExpression, $right));
    }

    /**
     * @param mixed $right
     *
     * @return ExprBuilder
     */
    public function div($right)
    {
        $right = static::normalizeExpression($right);

        return new self(new Arithmetic\Div($this->wrappedExpression, $right));
    }

    /**
     * @param mixed $right
     *
     * @return ExprBuilder
     */
    public function divide($right)
    {
        $right = static::normalizeExpression($right);

        return new self(new Arithmetic\Divide($this->wrappedExpression, $right));
    }

    /**
     * @param mixed $right
     *
     * @return ExprBuilder
     */
    public function modulo($right)
    {
        $right = static::normalizeExpression($right);

        return new self(new Arithmetic\Modulo($this->wrappedExpression, $right));
    }

    /**
     * @param mixed $right
     *
     * @return ExprBuilder
     */
    public function multiply($right)
    {
        $right = static::normalizeExpression($right);

        return new self(new Arithmetic\Multiply($this->wrappedExpression, $right));
    }

    /**
     * @param mixed $right
     *
     * @return ExprBuilder
     */
    public function subtract($right)
    {
        $right = static::normalizeExpression($right);

        return new self(new Arithmetic\Subtract($this->wrappedExpression, $right));
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
    public function year()
    {
        return new self(new Func\Year($this->wrappedExpression));
    }
}