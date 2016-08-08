<?php

namespace Phuria\QueryBuilder\Expression;

use Phuria\QueryBuilder\Reference\ColumnReference;

class ColumnExpression implements ExpressionInterface
{
    /**
     * @var ColumnReference $column
     */
    private $column;

    /**
     * @param ColumnReference $column
     */
    public function __construct(ColumnReference $column)
    {
        $this->column = $column;
    }
    /**
     * @return string
     */
    public function compile()
    {
        if ($alias = $this->column->getAlias()) {
            return $this->column->getFullName() . ' AS ' . $alias;
        }

        return $this->column->getFullName();
    }
}