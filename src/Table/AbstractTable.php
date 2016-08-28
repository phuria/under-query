<?php

namespace Phuria\QueryBuilder\Table;

use Phuria\QueryBuilder\QueryBuilder;
use Phuria\QueryBuilder\ReferenceManager;

/**
 * @author Beniamin Jonatan Šimko <spam@simko.it>
 */
abstract class AbstractTable
{
    const CROSS_JOIN = 'CROSS JOIN';
    const LEFT_JOIN = 'LEFT JOIN';
    const INNER_JOIN = 'INNER JOIN';

    /**
     * @var QueryBuilder $qb
     */
    private $qb;

    /**
     * @var string $tableAlias
     */
    private $tableAlias;

    /**
     * @var string $joinType
     */
    private $joinType;

    /**
     * @var string $joinOn
     */
    private $joinOn;

    /**
     * @var bool $root
     */
    private $root = false;

    /**
     * @var bool $join
     */
    private $join = false;

    /**
     * @param QueryBuilder $qb
     */
    public function __construct(QueryBuilder $qb)
    {
        $this->qb = $qb;
    }

    /**
     * @return ReferenceManager
     */
    public function __toString()
    {
        return $this->qb->getReferenceManager()->register($this);
    }

    /**
     * @return string
     */
    abstract public function getTableName();

    /**
     * @return QueryBuilder
     */
    public function getQueryBuilder()
    {
        return $this->qb;
    }

    /**
     * @return string
     */
    public function getAlias()
    {
        return $this->tableAlias;
    }

    /**
     * @param string $alias
     *
     * @return $this
     */
    public function setAlias($alias)
    {
        $this->tableAlias = $alias;

        return $this;
    }

    /**
     * @return bool
     */
    public function isJoin()
    {
        return $this->join;
    }

    /**
     * @return string
     */
    public function getJoinType()
    {
        return $this->joinType;
    }

    /**
     * @param string $joinType
     *
     * @return $this
     */
    public function setJoinType($joinType)
    {
        $this->joinType = $joinType;
        $this->join = true;

        return $this;
    }

    /**
     * @return bool
     */
    public function isRoot()
    {
        return $this->root;
    }

    /**
     * @param bool $root
     *
     * @return $this
     */
    public function setRoot($root)
    {
        $this->root = $root;

        return $this;
    }

    /**
     * @return string
     */
    public function getAliasOrName()
    {
        return $this->getAlias() ?: $this->getTableName();
    }

    /**
     * @param string $clause
     *
     * @return $this
     */
    public function addSelect($clause)
    {
        $this->qb->addSelect($clause);

        return $this;
    }

    /**
     * @param string $clause
     *
     * @return $this
     */
    public function joinOn($clause)
    {
        $this->joinOn = $clause;

        return $this;
    }

    /**
     * @return string
     */
    public function getJoinOn()
    {
        return $this->joinOn;
    }

    /**
     * @param string $name
     *
     * @return string
     */
    public function column($name)
    {
        return $this . '.' . $name;
    }
}