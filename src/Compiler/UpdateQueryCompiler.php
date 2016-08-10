<?php

namespace Phuria\QueryBuilder\Compiler;

use Phuria\QueryBuilder\QueryBuilder;

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
        return (bool) $qb->getSetClauses();
    }

    /**
     * @inheritdoc
     */
    public function compile(QueryBuilder $qb)
    {
        $commaSeparated = new SeparatedListCompiler(', ');

        $from = $commaSeparated->compile($qb->getRootTables());
        $set = $commaSeparated->compile($qb->getSetClauses());

        $sql = "UPDATE $from SET $set";

        return $sql;
    }
}