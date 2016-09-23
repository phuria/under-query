<?php

namespace Phuria\SQLBuilder\QueryCompiler;

use Phuria\SQLBuilder\Parser\QueryClausesParser;
use Phuria\SQLBuilder\Parser\ReferenceParser;
use Phuria\SQLBuilder\QueryBuilder;
use Phuria\SQLBuilder\Table\AbstractTable;

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
        foreach ($qb->getRootTables() as $rootTable) {
            if (AbstractTable::ROOT_FROM === $rootTable->getRootType()) {
                return true;
            }
        }

        return (bool) count($qb->getQueryClauses()->getSelectClauses());
    }

    /**
     * @inheritdoc
     */
    public function compile(QueryBuilder $qb)
    {
        $clausesParser = new QueryClausesParser($qb);

        $rawSQL = implode(' ', array_filter([
            $clausesParser->parseSelectClause(),
            $clausesParser->parseFromClause(),
            $clausesParser->parseJoinClause(),
            $clausesParser->parseWhereClause(),
            $clausesParser->parseGroupByClause(),
            $clausesParser->parseHavingClause(),
            $clausesParser->parseOrderByClause(),
            $clausesParser->parseLimitClause()
        ]));

        $referenceParser = new ReferenceParser($rawSQL, $qb->getReferenceManager());

        return $referenceParser->parseSQL();
    }
}