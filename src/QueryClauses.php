<?php

/**
 * This file is part of Phuria SQL Builder package.
 *
 * Copyright (c) 2016 Beniamin Jonatan Šimko
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Phuria\QueryBuilder;

use Phuria\QueryBuilder\Table\AbstractTable;

/**
 * @author Beniamin Jonatan Šimko <spam@simko.it>
 */
class QueryClauses
{
    const QUERY_SELECT = 1;
    const QUERY_UPDATE = 2;

    /**
     * @var QueryBuilder $qb
     */
    private $qb;

    /**
     * @var array $selectClauses
     */
    private $selectClauses = [];

    /**
     * @var array $whereClauses
     */
    private $whereClauses = [];

    /**
     * @var array $orderByClauses
     */
    private $orderByClauses = [];

    /**
     * @var array $setClauses
     */
    private $setClauses = [];

    /**
     * @var array $groupByClauses
     */
    private $groupByClauses = [];

    /**
     * @var array $havingClauses
     */
    private $havingClauses = [];

    /**
     * @var string $limitClause
     */
    private $limitClause;

    /**
     * @param QueryBuilder $qb
     */
    public function __construct(QueryBuilder $qb)
    {
        $this->qb = $qb;
    }

    /**
     * @return int
     */
    public function guessQueryType()
    {
        if ($this->selectClauses) {
            return static::QUERY_SELECT;
        }

        return static::QUERY_UPDATE;
    }

    /**
     * @param string $clause
     *
     * @return $this
     */
    public function addSelect($clause)
    {
        $this->selectClauses[] = $clause;

        return $this;
    }

    /**
     * @param string $clause
     *
     * @return $this
     */
    public function andWhere($clause)
    {
        $this->whereClauses[] = $clause;

        return $this;
    }

    /**
     * @param string $clause
     *
     * @return $this
     */
    public function andHaving($clause)
    {
        $this->havingClauses[] = $clause;

        return $this;
    }

    /**
     * @param string $clause
     *
     * @return $this
     */
    public function addOrderBy($clause)
    {
        $this->orderByClauses[] = $clause;

        return $this;
    }

    /**
     * @param string $clause
     *
     * @return $this
     */
    public function addSet($clause)
    {
        $this->setClauses[] = $clause;

        return $this;
    }

    /**
     * @param string $clause
     *
     * @return $this
     */
    public function addGroupBy($clause)
    {
        $this->groupByClauses[] = $clause;

        return $this;
    }

    /**
     * @param string $clause
     *
     * @return $this
     */
    public function setLimit($clause)
    {
        $this->limitClause = $clause;

        return $this;
    }

    /**
     * @return string
     */
    public function getRawSelectClause()
    {
        if ($this->selectClauses) {
            return 'SELECT ' . implode(', ', $this->selectClauses);
        }

        return '';
    }

    /**
     * @return string
     */
    public function getRawUpdateClause()
    {
        $rootTables = $this->qb->getRootTables();

        if (0 === count($rootTables)) {
            return '';
        }

        return 'UPDATE ' . implode(', ', array_map(function (AbstractTable $table) {
            if ($table->getAlias()) {
                return $table->getTableName() . ' AS ' . $table->getAlias();
            }

            return $table->getTableName();
        }, $rootTables));
    }

    /**
     * @return string
     */
    public function getRawFromClause()
    {
        $rootTables = $this->qb->getRootTables();

        if (0 === count($rootTables)) {
            return '';
        }

        return 'FROM ' . implode(', ', array_map(function (AbstractTable $table) {
            if ($table->getAlias()) {
                return $table->getTableName() . ' AS ' . $table->getAlias();
            }

            return $table->getTableName();
        }, $rootTables));
    }

    /**
     * @return string
     */
    public function getRawJoinClause()
    {
        $joinTables = $this->qb->getJoinTables();

        if (0 === count($joinTables)) {
            return '';
        }

        $joins = [];

        foreach ($joinTables as $table) {
            $clause = $table->getJoinType() . ' ' . $table->getTableName();

            if ($table->getAlias()) {
                $clause .= ' AS ' . $table->getAlias();
            }

            if ($table->getJoinOn()) {
                $clause .= ' ON ' . $table->getJoinOn();
            }

            $joins[] = $clause;
        }

        return implode(' ', $joins);
    }

    /**
     * @return string
     */
    public function getRawWhereClause()
    {
        if ($this->whereClauses) {
            return 'WHERE ' . implode(' AND ', $this->whereClauses);
        }

        return '';
    }

    /**
     * @return string
     */
    public function getRawOrderByClause()
    {
        if ($this->orderByClauses) {
            return 'ORDER BY ' . implode(', ', $this->orderByClauses);
        }

        return '';
    }

    /**
     * @return string
     */
    public function getRawSetClause()
    {
        if ($this->setClauses) {
            return 'SET ' . implode(', ', $this->setClauses);
        }

        return '';
    }

    /**
     * @return string
     */
    public function getRawGroupByClause()
    {
        if ($this->groupByClauses) {
            return 'GROUP BY ' . implode(', ', $this->groupByClauses);
        }

        return '';
    }

    /**
     * @return string
     */
    public function getRawHavingClause()
    {
        if ($this->havingClauses) {
            return 'HAVING ' . implode(' AND ', $this->havingClauses);
        }

        return '';
    }

    /**
     * @return string
     */
    public function getRawLimitClause()
    {
        if ($this->limitClause) {
            return 'LIMIT ' . $this->limitClause;
        }

        return '';
    }
}