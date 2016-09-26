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
     * @param string $alias
     * @param string $joinOn
     *
     * @return AbstractTable
     */
    private function join($joinType, $table, $alias = null, $joinOn = null)
    {
        $this->joinTables[] = $table = $this->getTableFactory()->createNewTable($table, $this->getQueryBuilder());
        $table->setJoinType($joinType);

        if ($alias) {
            $table->setAlias($alias);
        }

        if ($joinOn) {
            $table->joinOn($joinOn);
        }

        return $table;
    }

    /**
     * @param mixed  $table
     * @param string $alias
     * @param string $joinOn
     *
     * @return AbstractTable
     */
    public function crossJoin($table, $alias = null, $joinOn = null)
    {
        return $this->join(AbstractTable::CROSS_JOIN, $table, $alias, $joinOn);
    }

    /**
     * @param mixed  $table
     * @param string $alias
     * @param string $joinOn
     *
     * @return AbstractTable
     */
    public function leftJoin($table, $alias = null, $joinOn = null)
    {
        return $this->join(AbstractTable::LEFT_JOIN, $table, $alias, $joinOn);
    }

    /**
     * @param mixed  $table
     * @param string $alias
     * @param string $joinOn
     *
     * @return AbstractTable
     */
    public function innerJoin($table, $alias = null, $joinOn = null)
    {
        return $this->join(AbstractTable::INNER_JOIN, $table, $alias, $joinOn);
    }

    /**
     * @return array
     */
    public function getJoinTables()
    {
        return $this->joinTables;
    }
}