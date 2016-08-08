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
        return false === $qb->getQueryType()->isSelect() && $qb->getQueryType()->isUpdate();
    }

    /**
     * @inheritdoc
     */
    public function compile(QueryBuilder $qb)
    {
        $from = (new RootTableCompiler())->compile($qb);
        $set = (new UpdateSetCompiler())->compile($qb);

        $sql = "UPDATE $from SET $set";

        return $sql;
    }
}