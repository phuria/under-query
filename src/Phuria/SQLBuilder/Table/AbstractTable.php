<?php

namespace Phuria\SQLBuilder\Table;

use Phuria\SQLBuilder\QueryBuilder;
use Phuria\SQLBuilder\ReferenceManager;

/**
 * @author Beniamin Jonatan Šimko <spam@simko.it>
 */
abstract class AbstractTable
{
    const CROSS_JOIN = 'CROSS JOIN';
    const LEFT_JOIN = 'LEFT JOIN';
    const INNER_JOIN = 'INNER JOIN';

    const ROOT_FROM = 1;
    const ROOT_UPDATE = 2;
    const ROOT_INSERT = 3;

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
     * @var int $root
     */
    private $rootType;

    /**
     * @var string $joinOn
     */
    private $joinOn;

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
        return null !== $this->rootType;
    }

    /**
     * @param int $rootType
     *
     * @return $this
     */
    public function setRootType($rootType)
    {
        $this->rootType = $rootType;

        return $this;
    }

    /**
     * @return int
     */
    public function getRootType()
    {
        return $this->rootType;
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