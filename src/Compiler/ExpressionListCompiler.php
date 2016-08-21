<?php

/**
 * This file is part of Phuria SQL Builder package.
 *
 * Copyright (c) 2016 Beniamin Jonatan Šimko
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

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