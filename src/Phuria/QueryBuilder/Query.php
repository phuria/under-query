<?php

namespace Phuria\QueryBuilder;

use Phuria\QueryBuilder\Table\AbstractTable;

/**
 * @author Beniamin Jonatan Šimko <spam@simko.it>
 */
class Query
{
    public function __construct($select, AbstractTable $table, array $whereClauses)
    {
        $compiler = new ExpressionCompiler();

        $tableName = $table->getTableName();

        if ($alias = $table->getAlias()) {
            $tableName .= ' AS ' . $alias;
        }

        $this->sql = "SELECT $select FROM $tableName";

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