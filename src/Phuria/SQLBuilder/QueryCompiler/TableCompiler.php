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

use Phuria\SQLBuilder\JoinType;
use Phuria\SQLBuilder\QueryBuilder\BuilderInterface;
use Phuria\SQLBuilder\QueryBuilder\Component;
use Phuria\SQLBuilder\QueryBuilder\DeleteBuilder;
use Phuria\SQLBuilder\QueryBuilder\SelectBuilder;
use Phuria\SQLBuilder\Table\AbstractTable;

/**
 * @author Beniamin Jonatan Šimko <spam@simko.it>
 */
class TableCompiler
{
    /**
     * @var array
     */
    private $joinPrefixes;

    /**
     * TableCompiler constructor.
     */
    public function __construct()
    {
        $this->joinPrefixes = [
            JoinType::CROSS_JOIN    => 'CROSS',
            JoinType::LEFT_JOIN     => 'LEFT',
            JoinType::RIGHT_JOIN    => 'RIGHT',
            JoinType::INNER_JOIN    => 'INNER',
            JoinType::STRAIGHT_JOIN => 'STRAIGHT_JOIN'
        ];
    }

    /**
     * @param AbstractTable $table
     *
     * @return string
     */
    public function compileTableDeclaration(AbstractTable $table)
    {
        $declaration = '';

        if ($table->isJoin()) {
            $declaration .= $this->compileJoinName($table) . ' ';
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
     * @param AbstractTable $table
     *
     * @return string
     */
    private function compileJoinName(AbstractTable $table)
    {
        return implode(' ', array_filter([
            $table->isNaturalJoin() ? 'NATURAL' : '',
            $this->compileJoinPrefix($table->getJoinType()),
            $table->isOuterJoin() ? 'OUTER' : '',
            $this->compileJoinSuffix($table->getJoinType())
        ]));
    }

    /**
     * @param int $joinType
     *
     * @return string
     */
    private function compileJoinPrefix($joinType)
    {
        if (array_key_exists($joinType, $this->joinPrefixes)) {
            return $this->joinPrefixes[$joinType];
        }

        return null;
    }

    /**
     * @param int $joinType
     *
     * @return string
     */
    private function compileJoinSuffix($joinType)
    {
        return $joinType === JoinType::STRAIGHT_JOIN ? '' : 'JOIN';
    }

    /**
     * @param BuilderInterface $qb
     *
     * @return string
     */
    public function compileRootTables(BuilderInterface $qb)
    {
        $rootTables = '';

        if ($qb instanceof SelectBuilder || $qb instanceof DeleteBuilder) {
            $rootTables .= 'FROM ';
        }

        if ($qb instanceof Component\TableComponentInterface && $qb->getRootTables()) {
            $rootTables .= implode(', ', array_map([$this, 'compileTableDeclaration'], $qb->getRootTables()));
        } else {
            return '';
        }

        return $rootTables;
    }

    /**
     * @param BuilderInterface $qb
     *
     * @return string
     */
    public function compileJoinTables(BuilderInterface $qb)
    {
        if ($qb instanceof Component\JoinComponentInterface) {
            return implode(' ', array_map([$this, 'compileTableDeclaration'], $qb->getJoinTables()));
        }

        return '';
    }
}