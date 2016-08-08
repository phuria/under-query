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

        $joinTables = $qb->getJoinTables();

        $select = $compiler->compileSelect($qb->getSelectClauses());
        $where = $compiler->compileWhere($qb->getWhereClauses());
        $from = (new RootTableCompiler())->compile($qb);
        $join = $compiler->compileJoin($joinTables);
        $orderBy = $compiler->compileOrderBy($qb->getOrderByClauses());

        $sql = "SELECT $select FROM $from";

        if ($join) {
            $sql .= ' ' . $join;
        }

        if ($where) {
            $sql .= ' WHERE ' . $where;
        }

        if ($orderBy) {
            $sql .= ' ORDER BY ' . $orderBy;
        }

        return $sql;
    }
}