<?php

namespace Phuria\SQLBuilder\Table;

use Phuria\SQLBuilder\QueryBuilder\AbstractBuilder;

/**
 * @author Beniamin Jonatan Šimko <spam@simko.it>
 */
abstract class AbstractTable
{
    const CROSS_JOIN = 'CROSS JOIN';
    const LEFT_JOIN = 'LEFT JOIN';
    const INNER_JOIN = 'INNER JOIN';

    /**
     * @var AbstractBuilder $qb
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
     * @var bool $join
     */
    private $join = false;

    /**
     * @param AbstractBuilder $qb
     */
    public function __construct(AbstractBuilder $qb)
    {
        $this->qb = $qb;
    }

    /**
     * @return string
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
     * @return AbstractBuilder
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