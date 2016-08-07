<?php

namespace Phuria\QueryBuilder\Table;

use Phuria\QueryBuilder\Expression\ColumnExpression;
use Phuria\QueryBuilder\QueryBuilder;
use Phuria\QueryBuilder\Reference\ColumnReference;

/**
 * @author Beniamin Jonatan Šimko <spam@simko.it>
 */
abstract class AbstractTable
{
    /**
     * @var QueryBuilder $qb
     */
    private $qb;

    /**
     * @var string $tableAlias
     */
    private $tableAlias;

    /**
     * @var string $where
     */
    private $where;

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
    public function getAlias()
    {
        return $this->tableAlias;
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

    public function where($clause)
    {
        $this->where = $clause;

        return $this;
    }

    public function getWhere()
    {
        return $this->where;
    }
}