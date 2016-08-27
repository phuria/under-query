<?php

namespace Phuria\QueryBuilder\QueryCompiler;

use Phuria\QueryBuilder\Parser\QueryClausesParser;
use Phuria\QueryBuilder\QueryBuilder;
use Phuria\QueryBuilder\QueryClauses;
use Phuria\QueryBuilder\Table\AbstractTable;

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

        $references = $qb->getReferenceManager()->all();

        foreach ($references as &$value) {
            if ($value instanceof AbstractTable) {
                $value = $value->getAliasOrName();
            }
        }

        return str_replace(array_keys($references), array_values($references), $rawSQL);
    }
}