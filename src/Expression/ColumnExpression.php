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
     * @param string        $columnName
     */
    public function __construct(AbstractTable $table, $columnName)
    {
        $this->table = $table;
        $this->columnName = $columnName;
    }
    /**
     * @return string
     */
    public function compile()
    {
        return $this->table->getAliasOrName() . '.' . $this->columnName;
    }
}