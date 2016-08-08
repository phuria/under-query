<?php

namespace Phuria\QueryBuilder\Compiler;

use Phuria\QueryBuilder\QueryBuilder;
use Phuria\QueryBuilder\Table\AbstractTable;

/**
 * @author Beniamin Jonatan Šimko <spam@simko.it>
 */
class RootTableCompiler extends AbstractCompiler
{
    /**
     * @inheritdoc
     */
    public function compile(QueryBuilder $qb)
    {
        return implode(', ', array_map(function (AbstractTable $table) {
            return $this->fullTableName($table);
        }, $qb->getRootTables()));
    }
}