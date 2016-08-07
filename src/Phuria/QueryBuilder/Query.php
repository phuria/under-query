<?php

namespace Phuria\QueryBuilder;

use Phuria\QueryBuilder\Table\UnknownTable;

/**
 * @author Beniamin Jonatan Šimko <spam@simko.it>
 */
class Query
{
    public function __construct($select, $table)
    {
        if ($table instanceof UnknownTable) {
            $table = $table->getTableName();
        }

        $this->sql = "SELECT $select FROM $table";

    }

    public function getSQL()
    {
        return $this->sql;
    }

}