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
        $compiler = new ExpressionCompiler();

        $rootTables = $qb->getRootTables();

        $from = $compiler->compileFrom($rootTables);

        $sql = "UPDATE $from SET example.name = NULL";

        return $sql;
    }
}