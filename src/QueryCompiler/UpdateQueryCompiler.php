<?php

namespace Phuria\QueryBuilder\QueryCompiler;

use Phuria\QueryBuilder\QueryBuilder;
use Phuria\QueryBuilder\QueryClauses;

/**
 * @author Beniamin Jonatan Šimko <spam@simko.it>
 */
class UpdateQueryCompiler implements QueryCompilerInterface
{
    /**
     * @inheritdoc
     */
    public function canHandleQuery(QueryBuilder $qb)
    {
        return QueryClauses::QUERY_UPDATE === $qb->getQueryClauses()->guessQueryType();
    }

    /**
     * @inheritdoc
     */
    public function compile(QueryBuilder $qb)
    {
        return implode(' ', array_filter([
            'UPDATE',
            $qb->getRootTables()->compile(),
            $qb->getQueryClauses()->getSetExpression()->compile()
        ]));
    }
}