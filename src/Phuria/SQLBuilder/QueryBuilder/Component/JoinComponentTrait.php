<?php

/**
 * This file is part of Phuria SQL Builder package.
 *
 * Copyright (c) 2016 Beniamin Jonatan Šimko
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Phuria\SQLBuilder\QueryBuilder\Component;

use Phuria\SQLBuilder\QueryBuilder\AbstractBuilder;
use Phuria\SQLBuilder\Table\AbstractTable;
use Phuria\SQLBuilder\TableFactory\TableFactoryInterface;

/**
 * @author Beniamin Jonatan Šimko <spam@simko.it>
 */
trait JoinComponentTrait
{
    /**
     * @var array $joinTables
     */
    private $joinTables = [];

    /**
     * @return TableFactoryInterface
     */
    abstract protected function getTableFactory();
    /**
     * @return AbstractBuilder
     */
    abstract public function getQueryBuilder();

    /**
     * @param string $joinType
     * @param mixed  $table
     *
     * @return AbstractTable
     */
    public function join($joinType, $table)
    {
        $this->joinTables[] = $table = $this->getTableFactory()->createNewTable($table, $this->getQueryBuilder());
        $table->setJoinType($joinType);

        return $table;
    }

    /**
     * @param mixed $table
     *
     * @return AbstractTable
     */
    public function crossJoin($table)
    {
        return $this->join(AbstractTable::CROSS_JOIN, $table);
    }

    /**
     * @param mixed $table
     *
     * @return AbstractTable
     */
    public function leftJoin($table)
    {
        return $this->join(AbstractTable::LEFT_JOIN, $table);
    }

    /**
     * @param string $table
     *
     * @return AbstractTable
     */
    public function innerJoin($table)
    {
        return $this->join(AbstractTable::INNER_JOIN, $table);
    }

    /**
     * @return array
     */
    public function getJoinTables()
    {
        return $this->joinTables;
    }
}