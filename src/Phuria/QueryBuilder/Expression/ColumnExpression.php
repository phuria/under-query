<?php

namespace Phuria\QueryBuilder\Expression;

use Phuria\QueryBuilder\Table\AbstractTable;

class ColumnExpression implements ExpressionInterface
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

    /**
     * @return string
     */
    public function getFullName()
    {
        return $this->table->getAliasOrName() . '.' . $this->columnName;
    }

    /**
     * @return string
     */
    public function compile()
    {
        return $this->getFullName();
    }
}