<?php

namespace Phuria\QueryBuilder\Expression\Func;

use Phuria\QueryBuilder\ExprBuilder;
use Phuria\QueryBuilder\Expression\ExpressionInterface;
use Phuria\QueryBuilder\Expression\ImplodeExpression;
use Phuria\QueryBuilder\Expression\UsingExpression;

/**
 * @author Beniamin Jonatan Šimko <spam@simko.it>
 */
class FuncArguments implements ExpressionInterface
{
    /**
     * @var ExpressionInterface[] $args
     */
    private $args = [];

    /**
     * @param $argument
     *
     * @return $this
     */
    public function addArgument($argument)
    {
        if ($argument instanceof ImplodeExpression) {
            $argument = $argument->getExpressionList();
        }

        if (is_array($argument)) {
            $this->args +=  $argument;

            return $this;
        }

        $this->args[] = $argument;

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function compile()
    {
        $compiled = [];
        $using = '';

        foreach ($this->args as $arg) {
            if ($arg instanceof ExprBuilder) {
                $arg = $arg->getWrappedExpression();
            }

            if ($arg instanceof UsingExpression) {
                $using = $arg->compile();
                continue;
            }

            $compiled[] = $arg->compile();
        }

        $functionArguments = implode(', ', $compiled);

        if ($using) {
            $functionArguments .= $using;
        }

        return $functionArguments;
    }
}