<?php

namespace Phuria\QueryBuilder;

use Phuria\QueryBuilder\Table\UnknownTable;

/**
 * @author Beniamin Jonatan Šimko <spam@simko.it>
 */
class TableRegistry
{
    /**
     * @var array $tables
     */
    private $tableNameMap = [];

    /**
     * @var array $tableClassMap
     */
    private $tableClassMap = [];

    /**
     * @param string $tableClass
     * @param string $tableName
     *
     * @return $this
     */
    public function registerTable($tableClass, $tableName)
    {
        $this->tableClassMap[$tableClass] = $tableName;
        $this->tableNameMap[$tableName] = $tableClass;

        return $this;
    }

    /**
     * @param string $tableName
     *
     * @return string
     */
    public function getTableClass($tableName)
    {
        if (false === array_key_exists($tableName, $this->tableNameMap)) {
            return UnknownTable::class;
        }

        return $this->tableNameMap[$tableName];
    }
}