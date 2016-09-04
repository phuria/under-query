<?php

/**
 * This file is part of Phuria SQL Builder package.
 *
 * Copyright (c) 2016 Beniamin Jonatan Šimko
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Phuria\QueryBuilder\Parser;

use Phuria\QueryBuilder\QueryBuilder;
use Phuria\QueryBuilder\QueryClauses;
use Phuria\QueryBuilder\QueryHint;
use Phuria\QueryBuilder\Table\AbstractTable;

/**
 * @author Beniamin Jonatan Šimko <spam@simko.it>
 */
class QueryClausesParser
{
    /**
     * @var QueryClauses
     */
    private $queryClauses;

    /**
     * @var QueryBuilder $qb
     */
    private $qb;

    /**
     * @param QueryBuilder $qb
     */
    public function __construct(QueryBuilder $qb)
    {
        $this->queryClauses = $qb->getQueryClauses();
        $this->qb = $qb;
    }

    /**
     * @return string
     */
    public function parseSelectClause()
    {
        if ($clauses = $this->queryClauses->getSelectClauses()) {
            return 'SELECT ' . implode(', ', $clauses);
        }

        return '';
    }

    /**
     * @return string
     */
    public function parseUpdateClause()
    {
        $rootTables = $this->qb->getRootTables();

        if (0 === count($rootTables)) {
            return '';
        }

        $rootTableDeclaration = implode(', ', array_map(function (AbstractTable $table) {
            return $this->parseTableDeclaration($table);
        }, $rootTables));

        return implode(' ', array_filter(['UPDATE', $this->parseQueryHints(), $rootTableDeclaration]));
    }

    /**
     * @return string
     */
    public function parseFromClause()
    {
        $rootTables = $this->qb->getRootTables();

        if (0 === count($rootTables)) {
            return '';
        }

        return 'FROM ' . implode(', ', array_map(function (AbstractTable $table) {
            return $this->parseTableDeclaration($table);
        }, $rootTables));
    }

    /**
     * @return string
     */
    public function parseJoinClause()
    {
        $joinTables = $this->qb->getJoinTables();

        if (0 === count($joinTables)) {
            return '';
        }

        $joins = [];

        foreach ($joinTables as $table) {
            $joins[] = $this->parseTableDeclaration($table);
        }

        return implode(' ', $joins);
    }

    /**
     * @return string
     */
    public function parseWhereClause()
    {
        if ($clauses = $this->queryClauses->getWhereClauses()) {
            return 'WHERE ' . implode(' AND ', $clauses);
        }

        return '';
    }

    /**
     * @return string
     */
    public function parseOrderByClause()
    {
        if ($clauses = $this->queryClauses->getOrderByClauses()) {
            return 'ORDER BY ' . implode(', ', $clauses);
        }

        return '';
    }

    /**
     * @return string
     */
    public function parseSetClause()
    {
        if ($clauses = $this->queryClauses->getSetClauses()) {
            return 'SET ' . implode(', ', $clauses);
        }

        return '';
    }

    /**
     * @return string
     */
    public function parseGroupByClause()
    {
        if ($clauses = $this->queryClauses->getGroupByClauses()) {
            return 'GROUP BY ' . implode(', ', $clauses);
        }

        return '';
    }

    /**
     * @return string
     */
    public function parseHavingClause()
    {
        if ($clauses = $this->queryClauses->getHavingClauses()) {
            return 'HAVING ' . implode(' AND ', $clauses);
        }

        return '';
    }

    /**
     * @return string
     */
    public function parseLimitClause()
    {
        if ($clause = $this->queryClauses->getLimitClause()) {
            return 'LIMIT ' . $clause;
        }

        return '';
    }

    /**
     * @param AbstractTable $table
     *
     * @return string
     */
    private function parseTableDeclaration(AbstractTable $table)
    {
        $declaration = '';

        if ($table->isJoin()) {
            $declaration .= $table->getJoinType() . ' ';
        }

        $declaration .= $table->getTableName();

        if ($alias = $table->getAlias()) {
            $declaration .= ' AS ' . $alias;
        }

        if ($joinOn = $table->getJoinOn()) {
            $declaration .= ' ON ' . $joinOn;
        }

        return $declaration;
    }

    /**
     * @return string
     */
    private function parseQueryHints()
    {
        $hints = $this->queryClauses->getQueryHints();
        $parsedHint = '';

        if (array_key_exists(QueryHint::IGNORE, $hints)) {
            $parsedHint .= 'IGNORE';
        }

        return $parsedHint;
    }
}