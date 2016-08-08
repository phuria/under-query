<?php

namespace Phuria\QueryBuilder\Compiler;

use Phuria\QueryBuilder\Expression\ExpressionInterface;
use Phuria\QueryBuilder\Table\AbstractTable;

/**
 * @author Beniamin Jonatan Šimko <spam@simko.it>
 */
abstract class AbstractCompiler implements CompilerInterface
{
    /**
     * @param AbstractTable $table
     *
     * @return string
     */
    protected function fullTableName(AbstractTable $table)
    {
        $tableName = $table->getTableName();

        if ($alias = $table->getAlias()) {
            $tableName .= ' AS ' . $alias;
        }

        return $tableName;
    }

    /**
     * @param array $expressionList
     *
     * @return array
     */
    protected function compileExpressionList(array $expressionList)
    {
        $compiled = [];

        foreach ($expressionList as $expression) {
            if ($expression instanceof ExpressionInterface) {
                $expression = $expression->compile();
            }

            $compiled[] = $expression;
        }

        return $compiled;
    }
}