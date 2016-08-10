<?php

namespace Phuria\QueryBuilder\Compiler;

use Phuria\QueryBuilder\Expression\ExpressionInterface;
use Phuria\QueryBuilder\Table\AbstractTable;

/**
 * @author Beniamin Jonatan Šimko <spam@simko.it>
 */
class ExpressionListCompiler implements CompilerInterface
{
    /**
     * @inheritdoc
     */
    public function compile($stuff)
    {
        if (!$stuff) {
            return [];
        }

        $compiled = [];

        foreach ($stuff as $expression) {
            if ($expression instanceof ExpressionInterface) {
                $expression = $expression->compile();
            }

            if ($expression instanceof AbstractTable) {
                $expression = $this->fullTableName($expression);
            }

            $compiled[] = $expression;
        }

        return $compiled;
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
}