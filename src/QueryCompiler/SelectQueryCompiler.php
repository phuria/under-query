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
        $where = $andSeparated->compile($qb->getWhereClauses());
        $from = $commaSeparated->compile($qb->getRootTables());
        $join = $spaceSeparated->compile($qb->getJoinTables());
        $orderBy = $commaSeparated->compile($qb->getOrderByClauses());
        $groupBy = $commaSeparated->compile($qb->getGroupByClauses());

        $sql = "SELECT";

        if ($qb->isHighPriority()) {
            $sql .= ' HIGH_PRIORITY';
        }

        if ($statementTime = $qb->getMaxStatementTime()) {
            $sql .= ' MAX_STATEMENT_TIME ' . $statementTime;
        }

        if ($qb->isStraightJoin()) {
            $sql .= ' STRAIGHT_JOIN';
        }

        if ($qb->isSqlSmallResult()) {
            $sql .= ' SQL_SMALL_RESULT';
        }

        if ($qb->isSqlBigResult()) {
            $sql .= ' SQL_BIG_RESULT';
        }

        if ($qb->isSqlBufferResult()) {
            $sql .= ' SQL_BUFFER_RESULT';
        }

        if ($qb->isSqlNoCache()) {
            $sql .= ' SQL_NO_CACHE';
        }

        if ($qb->isSqlCalcFoundRows()) {
            $sql .= ' SQL_CALC_FOUND_ROWS';
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

        if ($orderBy) {
            $sql .= ' ORDER BY ' . $orderBy;
        }

        return $sql;
    }
}