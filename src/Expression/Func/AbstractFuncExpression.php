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
     * @return ExpressionInterface[]
     */
    public function getArguments()
    {
        return $this->args;
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
        $funcArguments = new FuncArguments();

        foreach ($this->args as $arg) {
            $funcArguments->addArgument($arg);
        }

        return $this->getName() . '(' . $funcArguments->compile() . ')';
    }
}