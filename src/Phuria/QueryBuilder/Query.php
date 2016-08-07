<?php

namespace Phuria\QueryBuilder;

use Phuria\QueryBuilder\Table\UnknownTable;

/**
 * @author Beniamin Jonatan Šimko <spam@simko.it>
 */
class Query
{
    public function __construct($select, UnknownTable $table)
    {
        $selectParts = $table->getSelectParts();
        $select = implode(', ', $selectParts);
        $tableName = $table->getTableName();

        if ($alias = $table->getAlias()) {
            $tableName .= ' AS ' . $alias;
        }

        $this->sql = "SELECT $select FROM $tableName";
    }

    public function getSQL()
    {
        return $this->sql;
    }

}