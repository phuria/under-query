<?php

/**
 * This file is part of UnderQuery package.
 *
 * Copyright (c) 2016 Beniamin Jonatan Šimko
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Phuria\UnderQuery\QueryBuilder\Component;

use Phuria\UnderQuery\JoinType;
use Phuria\UnderQuery\QueryBuilder\BuilderInterface;
use Phuria\UnderQuery\Table\AbstractTable;
use Phuria\UnderQuery\TableFactory\TableFactoryInterface;

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
     * @return BuilderInterface
     */
    abstract public function getQueryBuilder();

    /**
     * @param string      $joinType
     * @param mixed       $table
     * @param string|null $alias
     * @param string|null $joinOn
     *
     * @return AbstractTable
     */
    private function doJoin($joinType, $table, $alias = null, $joinOn = null)
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
     * @param mixed       $table
     * @param string|null $alias
     * @param string|null $joinOn
     *
     * @return AbstractTable
     */
    public function join($table, $alias = null, $joinOn = null)
    {
        return $this->doJoin(JoinType::JOIN, $table, $alias, $joinOn);
    }

    /**
     * @param mixed       $table
     * @param string|null $alias
     * @param string|null $joinOn
     *
     * @return AbstractTable
     */
    public function straightJoin($table, $alias = null, $joinOn = null)
    {
        return $this->doJoin(JoinType::STRAIGHT_JOIN, $table, $alias, $joinOn);
    }

    /**
     * @param mixed       $table
     * @param string|null $alias
     * @param string|null $joinOn
     *
     * @return AbstractTable
     */
    public function crossJoin($table, $alias = null, $joinOn = null)
    {
        return $this->doJoin(JoinType::CROSS_JOIN, $table, $alias, $joinOn);
    }

    /**
     * @param mixed       $table
     * @param string|null $alias
     * @param string|null $joinOn
     *
     * @return AbstractTable
     */
    public function leftJoin($table, $alias = null, $joinOn = null)
    {
        return $this->doJoin(JoinType::LEFT_JOIN, $table, $alias, $joinOn);
    }

    /**
     * @param mixed       $table
     * @param string|null $alias
     * @param string|null $joinOn
     *
     * @return AbstractTable
     */
    public function rightJoin($table, $alias = null, $joinOn = null)
    {
        return $this->doJoin(JoinType::RIGHT_JOIN, $table, $alias, $joinOn);
    }

    /**
     * @param mixed       $table
     * @param string|null $alias
     * @param string|null $joinOn
     *
     * @return AbstractTable
     */
    public function innerJoin($table, $alias = null, $joinOn = null)
    {
        return $this->doJoin(JoinType::INNER_JOIN, $table, $alias, $joinOn);
    }

    /**
     * @return array
     */
    public function getJoinTables()
    {
        return $this->joinTables;
    }
}