<?php

namespace Phuria\QueryBuilder\Table;

/**
 * @author Beniamin Jonatan Šimko <spam@simko.it>
 */
abstract class AbstractTable
{
    /**
     * @var string $tableAlias
     */
    private $tableAlias;

    /**
     * @var array $selectParts
     */
    private $selectParts = [];

    /**
     * @var string $where
     */
    private $where;

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
     * @param string $clause
     *
     * @return $this
     */
    public function addSelect($clause)
    {
        $this->selectParts[] = $clause;

        return $this;
    }

    /**
     * @return array
     */
    public function getSelectParts()
    {
        return $this->selectParts;
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