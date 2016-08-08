<?php

namespace Phuria\QueryBuilder;

use Phuria\QueryBuilder\Expression\ExpressionInterface;
use Phuria\QueryBuilder\Table\AbstractTable;

/**
 * @author Beniamin Jonatan Šimko <spam@simko.it>
 */
class ExpressionCompiler
{
    /**
     * @param array $expressionList
     *
     * @return string
     */
    public function compileSelect(array $expressionList)
    {
        return implode(', ', $this->compileExpressionList($expressionList));
    }

    /**
     * @param array $expressionList
     *
     * @return string
     */
    public function compileWhere(array $expressionList)
    {
        return implode(' AND ', $this->compileExpressionList($expressionList));
    }

    /**
     * @param AbstractTable[] $rootTables
     *
     * @return string
     */
    public function compileFrom(array $rootTables)
    {
        return implode(', ', array_map([$this, 'fullTableName'], $rootTables));
    }

    /**
     * @param AbstractTable[] $joinTables
     *
     * @return string
     */
    public function compileJoin(array $joinTables)
    {
        return implode(' ', array_map(function (AbstractTable $table) {
            $compiled = $table->getJoinType() . ' ' . $this->fullTableName($table);

            if ($joinOn = $table->getJoinOn()) {
                $compiled .= ' ON ' . $joinOn->compile();
            }

            return $compiled;
        }, $joinTables));
    }

    /**
     * @param array $expressionList
     *
     * @return string
     */
    public function compileOrderBy(array $expressionList)
    {
        return implode(', ', $this->compileExpressionList($expressionList));
    }

    /**
     * @param AbstractTable $table
     *
     * @return string
     */
    private function fullTableName(AbstractTable $table)
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
    private function compileExpressionList(array $expressionList)
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