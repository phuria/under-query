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
                $expression = $this->fullTableDeclaration($expression);
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
    private function fullTableDeclaration(AbstractTable $table)
    {
        $declaration = '';

        if ($table->isJoin()) {
            $declaration .= $table->getJoinType() . ' ';
        }

        $declaration .= $table->getTableName();

        if ($alias = $table->getAlias()) {
            $declaration .= ' AS ' . $alias;
        }

        if ($joinOn = $table->getJoinOn()) {
            $declaration .= ' ON ' . $joinOn->compile();
        }

        return $declaration;
    }
}