<?php

namespace Phuria\QueryBuilder\QueryCompiler;

use Phuria\QueryBuilder\Parser\QueryClausesParser;
use Phuria\QueryBuilder\Parser\ReferenceParser;
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
        $clausesParser = new QueryClausesParser($qb);

        $rawSQL = implode(' ', array_filter([
            $clausesParser->parseUpdateClause(),
            $clausesParser->parseSetClause()
        ]));

        $referenceParser = new ReferenceParser($rawSQL, $qb->getReferenceManager());

        return $referenceParser->parseSQL();
    }
}