<?php

namespace Phuria\QueryBuilder\Reference;

use Phuria\QueryBuilder\Table\AbstractTable;

class ColumnReference
{
    /**
     * @param AbstractTable $table
     * @param mixed         $columnName
     */
    public function __construct(AbstractTable $table, $columnName)
    {
        $this->table = $table;
        $this->columnName = $columnName;
    }

    /**
     * @return $this
     */
    public function select()
    {
        $this->table->addSelect($this);

        return $this;
    }

    public function getFullName()
    {
        return $this->table->getAliasOrName() . '.' . $this->columnName;
    }
}