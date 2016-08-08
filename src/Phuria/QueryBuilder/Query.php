<?php

namespace Phuria\QueryBuilder;

use Phuria\QueryBuilder\Table\AbstractTable;

/**
 * @author Beniamin Jonatan Šimko <spam@simko.it>
 */
class Query
{
    public function __construct($select, AbstractTable $table, array $whereClauses, array $tables)
    {
        $compiler = new ExpressionCompiler();

        $tableName = $table->getTableName();

        if ($alias = $table->getAlias()) {
            $tableName .= ' AS ' . $alias;
        }

        $this->sql = "SELECT $select FROM $tableName";

        foreach ($tables as $table) {
            $this->sql .= ' ' . $table->getJoinType() . ' JOIN ' . $table->getTableName();
        }

        $where = $compiler->compileWhere($whereClauses);

        if ($where) {
            $this->sql .= ' WHERE ' . $where;
        }
    }

    public function getSQL()
    {
        return $this->sql;
    }

}