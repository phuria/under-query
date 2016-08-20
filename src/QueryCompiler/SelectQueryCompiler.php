<?php

namespace Phuria\QueryBuilder\QueryCompiler;

use Phuria\QueryBuilder\Compiler\SeparatedListCompiler;
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
        return (bool) $qb->getSelectClauses();
    }

    /**
     * @inheritdoc
     */
    public function compile(QueryBuilder $qb)
    {
        $commaSeparated = new SeparatedListCompiler(', ');
        $andSeparated = new SeparatedListCompiler(' AND ');
        $spaceSeparated = new SeparatedListCompiler(' ');

        $select = $commaSeparated->compile($qb->getSelectClauses());
        $afterSelectHints = $spaceSeparated->compile($qb->getHints());
        $where = $andSeparated->compile($qb->getWhereClauses());
        $from = $commaSeparated->compile($qb->getRootTables());
        $join = $spaceSeparated->compile($qb->getJoinTables());
        $orderBy = $commaSeparated->compile($qb->getOrderByClauses());
        $groupBy = $commaSeparated->compile($qb->getGroupByClauses());
        $having = $andSeparated->compile($qb->getHavingClauses());

        $sql = "SELECT";

        if ($afterSelectHints) {
            $sql .= ' ' . $afterSelectHints;
        }

        if ($select) {
            $sql .= ' ' . $select;
        }

        if ($from) {
            $sql .= ' FROM ' . $from;
        }

        if ($join) {
            $sql .= ' ' . $join;
        }

        if ($where) {
            $sql .= ' WHERE ' . $where;
        }

        if ($groupBy) {
            $sql .= ' GROUP BY ' . $groupBy;
        }

        if ($having) {
            $sql .= ' HAVING ' . $having;
        }

        if ($orderBy) {
            $sql .= ' ORDER BY ' . $orderBy;
        }

        return $sql;
    }
}