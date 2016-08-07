<?php

namespace Phuria\QueryBuilder;

use Phuria\QueryBuilder\Table\AbstractTable;

/**
 * @author Beniamin Jonatan Šimko <spam@simko.it>
 */
class Query
{
    public function __construct($select, AbstractTable $table)
    {
        $tableName = $table->getTableName();

        if ($alias = $table->getAlias()) {
            $tableName .= ' AS ' . $alias;
        }

        $this->sql = "SELECT $select FROM $tableName";

        if ($where = $table->getWhere()) {
            $this->sql .= ' WHERE ' . $where;
        }
    }

    public function getSQL()
    {
        return $this->sql;
    }

}