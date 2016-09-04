<?php

namespace Phuria\QueryBuilder\QueryCompiler;

use Phuria\QueryBuilder\Parser\QueryClausesParser;
use Phuria\QueryBuilder\Parser\ReferenceParser;
use Phuria\QueryBuilder\QueryBuilder;
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
        foreach ($qb->getRootTables() as $rootTable) {
            if (AbstractTable::ROOT_FROM === $rootTable->getRootType()) {
                return true;
            }
        }

        if (count($qb->getQueryClauses()->getSelectClauses())) {
            return true;
        }

        return false;
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