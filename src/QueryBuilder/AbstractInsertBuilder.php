<?php

/**
 * This file is part of UnderQuery package.
 *
 * Copyright (c) 2016 Beniamin Jonatan Šimko
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Phuria\UnderQuery\QueryBuilder;

use Phuria\UnderQuery\Table\AbstractTable;

/**
 * @author Beniamin Jonatan Šimko <spam@simko.it>
 */
abstract class AbstractInsertBuilder extends AbstractBuilder
{
    /**
     * @var array
     */
    private $columns = [];

    /**
     * @param array $columns
     *
     * @return $this
     */
    public function setColumns($columns)
    {
        $this->columns = $columns;

        return $this;
    }

    /**
     * @param mixed $column
     *
     * @return $this
     */
    public function addColumn($column)
    {
        $this->columns[] = $column;

        return $this;
    }

    /**
     * @return array
     */
    public function getColumns()
    {
        return $this->columns;
    }

    /**
     * @param mixed $table
     * @param array $columns
     *
     * @return AbstractTable
     */
    public function into($table, array $columns = [])
    {
        if (count($columns)) {
            $this->setColumns($columns);
        }

        return $this->addRootTable($table);
    }
}