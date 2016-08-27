<?php

namespace Phuria\QueryBuilder\QueryCompiler;

use Phuria\QueryBuilder\Parser\QueryClausesParser;
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
        $clausesParser = new QueryClausesParser($qb);

        $rawSql = implode(' ', array_filter([
            $clausesParser->parseSelectClause(),
            $clausesParser->parseFromClause(),
            $clausesParser->parseJoinClause(),
            $clausesParser->parseWhereClause(),
            $clausesParser->parseGroupByClause(),
            $clausesParser->parseHavingClause(),
            $clausesParser->parseOrderByClause(),
            $clausesParser->parseLimitClause()
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