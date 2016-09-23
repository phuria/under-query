<?php

/**
 * This file is part of Phuria SQL Builder package.
 *
 * Copyright (c) 2016 Beniamin Jonatan Šimko
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Phuria\SQLBuilder;

/**
 * @author Beniamin Jonatan Šimko <spam@simko.it>
 */
class QueryClauses
{
    const QUERY_SELECT = 1;
    const QUERY_UPDATE = 2;

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
     * @var array $queryHints
     */
    private $queryHints = [];

    /**
     * @var array $insertColumns
     */
    private $insertColumns = [];

    /**
     * @var array $insertValues
     */
    private $insertValues = [];

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
     * @param int    $hint
     * @param mixed $value
     *
     * @return $this
     */
    public function addQueryHint($hint, $value = null)
    {
        $this->queryHints[$hint] = $value;

        return $this;
    }

    /**
     * @param array $columns
     *
     * @return $this
     */
    public function setInsertColumns(array $columns = [])
    {
        $this->insertColumns = $columns;

        return $this;
    }

    /**
     * @param $value
     *
     * @return $this
     */
    public function addInsertValue($value)
    {
        $this->insertValues[] = $value;

        return $this;
    }

    /**
     * @return array
     */
    public function getSelectClauses()
    {
        return $this->selectClauses;
    }

    /**
     * @return array
     */
    public function getWhereClauses()
    {
        return $this->whereClauses;
    }

    /**
     * @return array
     */
    public function getOrderByClauses()
    {
        return $this->orderByClauses;
    }

    /**
     * @return array
     */
    public function getSetClauses()
    {
        return $this->setClauses;
    }

    /**
     * @return array
     */
    public function getGroupByClauses()
    {
        return $this->groupByClauses;
    }

    /**
     * @return array
     */
    public function getHavingClauses()
    {
        return $this->havingClauses;
    }

    /**
     * @return string
     */
    public function getLimitClause()
    {
        return $this->limitClause;
    }

    /**
     * @return array
     */
    public function getQueryHints()
    {
        return $this->queryHints;
    }

    /**
     * @return array
     */
    public function getInsertValues()
    {
        return $this->insertValues;
    }
}