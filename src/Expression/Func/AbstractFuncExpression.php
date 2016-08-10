<?php

namespace Phuria\QueryBuilder\Expression\Func;

use Phuria\QueryBuilder\Expression\ExpressionInterface;

/**
 * @author Beniamin Jonatan Šimko <spam@simko.it>
 */
abstract class AbstractFuncExpression implements ExpressionInterface
{
    /**
     * @var ExpressionInterface[] $args
     */
    private $args;

    /**
     * AbstractFuncExpression constructor.
     */
    public function __construct()
    {
        $this->args = func_get_args();
    }

    /**
     * @return string
     */
    abstract public function getName();

    /**
     * @inheritdoc
     */
    public function compile()
    {
        $compiled = [];

        foreach ($this->args as $arg) {
            $compiled[] = $arg->compile();
        }

        return $this->getName() . '(' . implode(', ', $compiled) . ')';
    }
}