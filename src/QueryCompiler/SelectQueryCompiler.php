<?php

namespace Phuria\QueryBuilder\QueryCompiler;

use Phuria\QueryBuilder\QueryBuilder;
use Phuria\QueryBuilder\QueryClauses;

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

        return implode(' ', array_filter([
            $clauses->getSelectExpression()->compile(),
            $qb->getRootTables()->isEmpty() ? '' : 'FROM ' . $qb->getRootTables()->compile(),
            $qb->getJoinTables()->compile(),
            $clauses->getWhereExpression()->compile(),
            $clauses->getGroupByExpression()->compile(),
            $clauses->getHavingExpression()->compile(),
            $clauses->getOrderByExpression()->compile()
        ]));
    }
}