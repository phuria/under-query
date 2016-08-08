<?php

namespace Phuria\QueryBuilder\Compiler;

use Phuria\QueryBuilder\ExpressionCompiler;
use Phuria\QueryBuilder\QueryBuilder;
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
        return false === $qb->getQueryType()->isSelect() && $qb->getQueryType()->isUpdate();
    }

    /**
     * @inheritdoc
     */
    public function compile(QueryBuilder $qb)
    {
        $from = (new RootTableCompiler())->compile($qb);

        $sql = "UPDATE $from SET example.name = NULL";

        return $sql;
    }
}