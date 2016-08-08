<?php

namespace Phuria\QueryBuilder;

use Phuria\QueryBuilder\Expression\ExpressionInterface;

/**
 * @author Beniamin Jonatan Šimko <spam@simko.it>
 */
class ExpressionCompiler
{
    public function compileSelect()
    {

    }

    /**
     * @param array $expressionList
     *
     * @return string
     */
    public function compileWhere(array $expressionList)
    {
        $compiled = [];

        foreach ($expressionList as $expression) {
            if ($expression instanceof ExpressionInterface) {
                $expression = $expression->compile();
            }

            $compiled[] = $expression;
        }

        return implode(' AND ', $compiled);
    }
}