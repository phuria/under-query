<?php

/**
 * This file is part of Phuria SQL Builder package.
 *
 * Copyright (c) 2016 Beniamin Jonatan Šimko
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Phuria\UnderQuery\QueryCompiler;

use Phuria\UnderQuery\JoinType;
use Phuria\UnderQuery\QueryBuilder\Component;
use Phuria\UnderQuery\QueryBuilder\DeleteBuilder;
use Phuria\UnderQuery\QueryBuilder\SelectBuilder;
use Phuria\UnderQuery\Table\AbstractTable;

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
     * @param CompilerPayload $payload
     *
     * @return CompilerPayload
     */
    public function compileRootTables(CompilerPayload $payload)
    {
        $builder = $payload->getBuilder();
        $newSQL = '';

        if ($builder instanceof Component\TableComponentInterface && $builder->getRootTables()) {
            $newSQL = implode(', ', array_map([$this, 'compileTableDeclaration'], $builder->getRootTables()));
        }

        if ($builder instanceof SelectBuilder || $builder instanceof DeleteBuilder) {
            $newSQL = $newSQL ? 'FROM ' . $newSQL : '';
        }

        return $payload->appendSQL($newSQL);
    }

    /**
     * @param CompilerPayload $payload
     *
     * @return CompilerPayload
     */
    public function compileJoinTables(CompilerPayload $payload)
    {
        $builder = $payload->getBuilder();

        if ($builder instanceof Component\JoinComponentInterface) {
            $newSQL = implode(' ', array_map([$this, 'compileTableDeclaration'], $builder->getJoinTables()));
            return $payload->appendSQL($newSQL);
        }

        return $payload;
    }
}