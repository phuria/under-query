<?php

namespace Phuria\UnderQuery;

/**
 * This file is part of Phuria SQL Builder package.
 *
 * Copyright (c) 2016 Beniamin Jonatan Šimko
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use Phuria\UnderQuery\Table\UnknownTable;

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
     * @param string $tableClass
     * @param string $tableName
     *
     * @return $this
     */
    public function registerTable($tableClass, $tableName)
    {
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