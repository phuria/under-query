<?php

/**
 * This file is part of Phuria SQL Builder package.
 *
 * Copyright (c) 2016 Beniamin Jonatan Šimko
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

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
     * @inheritdoc
     */
    public function compile()
    {
        return $this->table->getAliasOrName() . '.' . $this->columnName;
    }
}