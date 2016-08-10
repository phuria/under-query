<?php

namespace Phuria\QueryBuilder\Compiler;

use Phuria\QueryBuilder\ExpressionCompiler;
use Phuria\QueryBuilder\QueryBuilder;

/**
 * @author Beniamin Jonatan Šimko <spam@simko.it>
 */
class SelectQueryCompiler implements QueryCompilerInterface
{
    /**
     * @inheritdoc
     */
    public function canHandleQuery(QueryBuilder $qb)
    {
        return $qb->getQueryType()->isSelect() && false === $qb->getQueryType()->isUpdate();
    }

    /**
     * @inheritdoc
     */
    public function compile(QueryBuilder $qb)
    {
        $compiler = new ExpressionCompiler();
        $commaSeparated = new SeparatedListCompiler(', ');

        $joinTables = $qb->getJoinTables();

        $select = $compiler->compileSelect($qb->getSelectClauses());
        $where = $compiler->compileWhere($qb->getWhereClauses());
        $from = $commaSeparated->compile($qb->getRootTables());
        $join = $compiler->compileJoin($joinTables);
        $orderBy = $compiler->compileOrderBy($qb->getOrderByClauses());
        $groupBy = $commaSeparated->compile($qb->getGroupByClauses());

        $sql = "SELECT $select FROM $from";

        if ($join) {
            $sql .= ' ' . $join;
        }

        if ($where) {
            $sql .= ' WHERE ' . $where;
        }

        if ($groupBy) {
            $sql .= ' GROUP BY ' . $groupBy;
        }

        if ($orderBy) {
            $sql .= ' ORDER BY ' . $orderBy;
        }

        return $sql;
    }
}