<?php

namespace Phuria\QueryBuilder\Reference;

use Phuria\QueryBuilder\Table\AbstractTable;

/**
 * @author Beniamin Jonatan Šimko <spam@simko.it>
 */
class ColumnReference
{
    /**
     * @var AbstractTable $table
     */
    private $table;

    /**
     * @var string $columnName
     */
    private $columnName;

    /**
     * @var string $alias
     */
    private $alias;

    /**
     * @param AbstractTable $table
     * @param string        $columnName
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

    public function alias($alias)
    {
        $this->alias = $alias;

        return $this;
    }

    public function getAlias()
    {
        return $this->alias;
    }

    /**
     * @return string
     */
    public function getFullName()
    {
        return $this->table->getAliasOrName() . '.' . $this->columnName;
    }
}