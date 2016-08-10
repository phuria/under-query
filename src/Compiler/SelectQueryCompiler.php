<?php

namespace Phuria\QueryBuilder\Compiler;

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
        $commaSeparated = new SeparatedListCompiler(', ');
        $andSeparated = new SeparatedListCompiler(' AND ');
        $spaceSeparated = new SeparatedListCompiler(' ');

        $select = $commaSeparated->compile($qb->getSelectClauses());
        $where = $andSeparated->compile($qb->getWhereClauses());
        $from = $commaSeparated->compile($qb->getRootTables());
        $join = $spaceSeparated->compile($qb->getJoinTables());
        $orderBy = $commaSeparated->compile($qb->getOrderByClauses());
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