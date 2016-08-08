<?php

namespace Phuria\QueryBuilder\Table;

use Phuria\QueryBuilder\QueryBuilder;
use Phuria\QueryBuilder\Reference\ColumnReference;

/**
 * @author Beniamin Jonatan Šimko <spam@simko.it>
 */
abstract class AbstractTable
{
    const CROSS_JOIN = 'CROSS';

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
     * @param QueryBuilder $qb
     */
    public function __construct(QueryBuilder $qb)
    {
        $this->qb = $qb;
    }

    /**
     * @return string
     */
    abstract public function getTableName();

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
     * @return string
     */
    public function getJoinType()
    {
        return $this->joinType;
    }

    /**
     * @param string $joinType
     */
    public function setJoinType($joinType)
    {
        $this->joinType = $joinType;
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

    public function column($name)
    {
        return new ColumnReference($this, $name);
    }
}