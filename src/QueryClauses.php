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

use Phuria\QueryBuilder\Expression\ExpressionCollection;
use Phuria\QueryBuilder\Expression\ExpressionInterface;
use Phuria\QueryBuilder\Expression\QueryClauseExpression as QueryExpr;
use Phuria\QueryBuilder\Expression\SelectClauseExpression;

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
     * @var array $hints
     */
    private $hints = [];

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
     * @return $this
     */
    public function addSelect()
    {
        $this->selectClauses[] = ExprNormalizer::normalizeExpression(func_get_args());

        return $this;
    }

    /**
     * @return $this
     */
    public function andWhere()
    {
        $this->whereClauses[] = ExprNormalizer::normalizeExpression(func_get_args());

        return $this;
    }

    /**
     * @return $this
     */
    public function andHaving()
    {
        $this->havingClauses[] = ExprNormalizer::normalizeExpression(func_get_args());

        return $this;
    }

    /**
     * @return $this
     */
    public function addOrderBy()
    {
        $this->orderByClauses[] = ExprNormalizer::normalizeExpression(func_get_args());

        return $this;
    }

    /**
     * @return $this
     */
    public function addSet()
    {
        $this->setClauses[] = ExprNormalizer::normalizeExpression(func_get_args());

        return $this;
    }

    /**
     * @return $this
     */
    public function addGroupBy()
    {
        $this->groupByClauses[] = ExprNormalizer::normalizeExpression(func_get_args());

        return $this;
    }

    /**
     * @return $this
     */
    public function addHint()
    {
        $this->hints[] = ExprNormalizer::normalizeExpression(func_get_args());

        return $this;
    }

    /**
     * @return ExpressionInterface
     */
    public function getSelectExpression()
    {
        return new SelectClauseExpression(
            new ExpressionCollection($this->hints, ' '),
            new ExpressionCollection($this->selectClauses, ', ')
        );
    }

    /**
     * @return ExpressionInterface
     */
    public function getWhereExpression()
    {
        return new QueryExpr(
            QueryExpr::CLAUSE_WHERE,
            new ExpressionCollection($this->whereClauses, ' AND ')
        );
    }

    /**
     * @return ExpressionInterface
     */
    public function getOrderByExpression()
    {
        return new QueryExpr(
            QueryExpr::CLAUSE_ORDER_BY,
            new ExpressionCollection($this->orderByClauses, ', ')
        );
    }

    /**
     * @return ExpressionInterface
     */
    public function getSetExpression()
    {
        return new QueryExpr(
            QueryExpr::CLAUSE_SET,
            new ExpressionCollection($this->setClauses, ', ')
        );
    }

    /**
     * @return ExpressionInterface
     */
    public function getGroupByExpression()
    {
        return new QueryExpr(
            QueryExpr::CLAUSE_GROUP_BY,
            new ExpressionCollection($this->groupByClauses, ', ')
        );
    }

    /**
     * @return ExpressionInterface
     */
    public function getHavingExpression()
    {
        return new QueryExpr(
            QueryExpr::CLAUSE_HAVING,
            new ExpressionCollection($this->havingClauses, ' AND ')
        );
    }
}