<?php

namespace Phuria\QueryBuilder\QueryCompiler;

use Phuria\QueryBuilder\QueryBuilder;
use Phuria\QueryBuilder\QueryClauses;
use Phuria\QueryBuilder\Table\AbstractTable;

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
        return QueryClauses::QUERY_SELECT === $qb->getQueryClauses()->guessQueryType();
    }

    /**
     * @inheritdoc
     */
    public function compile(QueryBuilder $qb)
    {
        $clauses = $qb->getQueryClauses();

        $rawSql = implode(' ', array_filter([
            $clauses->getRawSelectClause(),
            $clauses->getRawFromClause(),
            $clauses->getRawJoinClause(),
            $clauses->getRawWhereClause(),
            $clauses->getRawGroupByClause(),
            $clauses->getRawHavingClause(),
            $clauses->getRawOrderByClause(),
            $clauses->getRawLimitClause()
        ]));

        $references = $qb->getReferenceManager()->all();

        foreach ($references as &$value) {
            if ($value instanceof AbstractTable) {
                $value = $value->getAliasOrName();
            }
        }

        return str_replace(array_keys($references), array_values($references), $rawSql);
    }
}