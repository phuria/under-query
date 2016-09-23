<?php

namespace Phuria\SQLBuilder\QueryCompiler;

use Phuria\SQLBuilder\Parser\QueryClausesParser;
use Phuria\SQLBuilder\Parser\ReferenceParser;
use Phuria\SQLBuilder\QueryBuilder;
use Phuria\SQLBuilder\Table\AbstractTable;

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
        foreach ($qb->getRootTables() as $rootTable) {
            if (AbstractTable::ROOT_UPDATE === $rootTable->getRootType()) {
                return true;
            }
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
            $clausesParser->parseUpdateClause(),
            $clausesParser->parseSetClause(),
            $clausesParser->parseWhereClause(),
            $clausesParser->parseOrderByClause(),
            $clausesParser->parseLimitClause()
        ]));

        $referenceParser = new ReferenceParser($rawSQL, $qb->getReferenceManager());

        return $referenceParser->parseSQL();
    }
}