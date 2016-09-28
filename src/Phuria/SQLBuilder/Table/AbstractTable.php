<?php

namespace Phuria\SQLBuilder\Table;

use Phuria\SQLBuilder\QueryBuilder\BuilderInterface;

/**
 * @author Beniamin Jonatan Šimko <spam@simko.it>
 */
abstract class AbstractTable implements TableInterface
{
    /**
     * @var BuilderInterface
     */
    private $qb;

    /**
     * @var string
     */
    private $tableAlias;

    /**
     * @var int
     */
    private $joinType;

    /**
     * @var string
     */
    private $joinOn;

    /**
     * @var bool
     */
    private $outerJoin = false;

    /**
     * @var bool
     */
    private $naturalJoin = false;

    /**
     * @param BuilderInterface $qb
     */
    public function __construct(BuilderInterface $qb)
    {
        $this->qb = $qb;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->getQueryBuilder()->objectToString($this);
    }

    /**
     * @inheritdoc
     */
    public function getAliasOrName()
    {
        return $this->getAlias() ?: $this->getTableName();
    }

    /**
     * @return BuilderInterface
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
        return (bool) $this->joinType;
    }

    /**
     * @return int
     */
    public function getJoinType()
    {
        return $this->joinType;
    }

    /**
     * @param int $joinType
     *
     * @return $this
     */
    public function setJoinType($joinType)
    {
        $this->joinType = $joinType;

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
     * @return boolean
     */
    public function isOuterJoin()
    {
        return $this->outerJoin;
    }

    /**
     * @param boolean $outerJoin
     */
    public function setOuterJoin($outerJoin)
    {
        $this->outerJoin = $outerJoin;
    }

    /**
     * @return boolean
     */
    public function isNaturalJoin()
    {
        return $this->naturalJoin;
    }

    /**
     * @param boolean $naturalJoin
     */
    public function setNaturalJoin($naturalJoin)
    {
        $this->naturalJoin = $naturalJoin;
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