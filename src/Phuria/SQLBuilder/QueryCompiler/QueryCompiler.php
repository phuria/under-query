<?php

/**
 * This file is part of Phuria SQL Builder package.
 *
 * Copyright (c) 2016 Beniamin Jonatan Šimko
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Phuria\SQLBuilder\QueryCompiler;

use Phuria\SQLBuilder\Parser\ReferenceParser;
use Phuria\SQLBuilder\QueryBuilder\AbstractBuilder;
use Phuria\SQLBuilder\QueryBuilder\Clause;
use Phuria\SQLBuilder\QueryBuilder\Component;
use Phuria\SQLBuilder\QueryBuilder\InsertBuilder;
use Phuria\SQLBuilder\QueryBuilder\UpdateBuilder;

/**
 * @author Beniamin Jonatan Šimko <spam@simko.it>
 */
class QueryCompiler implements QueryCompilerInterface
{
    /**
     * @var TableCompiler
     */
    private $tableCompiler;

    public function __construct()
    {
        $this->tableCompiler = new TableCompiler();
    }

    /**
     * @inheritdoc
     */
    public function compile(AbstractBuilder $qb)
    {
        return $this->compileReferences($this->compileRaw($qb), $qb);
    }

    /**
     * @param AbstractBuilder $qb
     *
     * @return string
     */
    private function compileRaw(AbstractBuilder $qb)
    {
        return implode(' ', array_filter([
            $this->compileDelete($qb),
            $this->compileInsert($qb),
            $this->compileUpdate($qb),
            $this->compileSelect($qb),
            $this->tableCompiler->compileRootTables($qb),
            $this->tableCompiler->compileJoinTables($qb),
            $this->compileInsertColumns($qb),
            $this->compileSet($qb),
            $this->compileWhere($qb),
            $this->compileInsertValues($qb),
            $this->compileGroupBy($qb),
            $this->compileHaving($qb),
            $this->compileOrderBy($qb),
            $this->compileLimit($qb)
        ]));
    }

    /**
     * @param string          $rawSQL
     * @param AbstractBuilder $qb
     *
     * @return string
     */
    private function compileReferences($rawSQL, AbstractBuilder $qb)
    {
        return (new ReferenceParser($rawSQL, $qb->getReferenceManager()))->parseSQL();
    }

    /**
     * @param AbstractBuilder $qb
     *
     * @return string
     */
    private function compileDelete(AbstractBuilder $qb)
    {
        if ($qb instanceof Clause\DeleteClauseInterface) {
            return $qb->getDeleteClauses() ? 'DELETE ' . implode(', ', $qb->getDeleteClauses()) : 'DELETE';
        }

        return '';
    }

    /**
     * @param AbstractBuilder $qb
     *
     * @return string
     */
    private function compileInsert(AbstractBuilder $qb)
    {
        if ($qb instanceof InsertBuilder) {
            return 'INSERT INTO';
        }

        return '';
    }

    /**
     * @param AbstractBuilder $qb
     *
     * @return string
     */
    private function compileUpdate(AbstractBuilder $qb)
    {
        if ($qb instanceof UpdateBuilder) {
            return $qb->isIgnore() ? 'UPDATE IGNORE' : 'UPDATE';
        }

        return '';
    }

    /**
     * @param AbstractBuilder $qb
     *
     * @return string
     */
    private function compileSelect(AbstractBuilder $qb)
    {
        if ($qb instanceof Clause\SelectClauseInterface) {
            return 'SELECT ' . implode(', ', $qb->getSelectClauses());
        }

        return '';
    }

    /**
     * @param AbstractBuilder $qb
     *
     * @return string
     */
    private function compileSet(AbstractBuilder $qb)
    {
        if ($qb instanceof Clause\SetClauseInterface && $qb->getSetClauses()) {
            return 'SET ' . implode(', ', $qb->getSetClauses());
        }

        return '';
    }

    /**
     * @param AbstractBuilder $qb
     *
     * @return string
     */
    private function compileWhere(AbstractBuilder $qb)
    {
        if ($qb instanceof Clause\WhereClauseInterface && $qb->getWhereClauses()) {
            return 'WHERE ' . implode(' AND ', $qb->getWhereClauses());
        }

        return '';
    }

    /**
     * @param AbstractBuilder $qb
     *
     * @return string
     */
    private function compileGroupBy(AbstractBuilder $qb)
    {
        if ($qb instanceof Clause\GroupByClauseInterface && $qb->getGroupByClauses()) {
            $clause = 'GROUP BY ' . implode(', ', $qb->getGroupByClauses());

            return $qb->isGroupByWithRollUp() ? $clause . ' WITH ROLLUP' : $clause;
        }

        return '';
    }

    /**
     * @param AbstractBuilder $qb
     *
     * @return string
     */
    private function compileHaving(AbstractBuilder $qb)
    {
        if ($qb instanceof Clause\HavingClauseInterface && $qb->getHavingClauses()) {
            return 'HAVING ' . implode(' AND ', $qb->getHavingClauses());
        }

        return '';
    }

    /**
     * @param AbstractBuilder $qb
     *
     * @return string
     */
    private function compileOrderBy(AbstractBuilder $qb)
    {
        if ($qb instanceof Clause\OrderByClauseInterface && $qb->getOrderByClauses()) {
            return 'ORDER BY ' . implode(', ', $qb->getOrderByClauses());
        }

        return '';
    }

    /**
     * @param AbstractBuilder $qb
     *
     * @return string
     */
    private function compileLimit(AbstractBuilder $qb)
    {
        if ($qb instanceof Clause\LimitClauseInterface && $qb->getLimitClause()) {
            return 'LIMIT ' . $qb->getLimitClause();
        }

        return '';
    }

    /**
     * @param AbstractBuilder $qb
     *
     * @return string
     */
    private function compileInsertValues(AbstractBuilder $qb)
    {
        if ($qb instanceof Component\InsertValuesComponentInterface) {
            return 'VALUES ' . implode(', ', array_map(function (array $values) {
                return '('. implode(', ', $values) . ')';
            }, $qb->getValues()));
        }

        return '';
    }

    /**
     * @param AbstractBuilder $qb
     *
     * @return string
     */
    private function compileInsertColumns(AbstractBuilder $qb)
    {
        if ($qb instanceof Clause\InsertColumnsClauseInterface) {
            return '(' . implode(', ', $qb->getColumns()) . ')';
        }

        return '';
    }
}