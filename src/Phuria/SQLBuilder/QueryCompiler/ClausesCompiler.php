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

use Phuria\SQLBuilder\QueryBuilder\Clause;

/**
 * @author Beniamin Jonatan Šimko <spam@simko.it>
 */
class ClausesCompiler
{
    /**
     * @param CompilerPayload $payload
     *
     * @return CompilerPayload
     */
    public function compileWhere(CompilerPayload $payload)
    {
        $builder = $payload->getBuilder();

        if ($builder instanceof Clause\WhereClauseInterface && $builder->getWhereClauses()) {
            $newSQL = 'WHERE ' . implode(' AND ', $builder->getWhereClauses());
            $payload = $payload->appendSQL($newSQL);
        }

        return $payload;
    }

    /**
     * @param CompilerPayload $payload
     *
     * @return CompilerPayload
     */
    public function compileGroupBy(CompilerPayload $payload)
    {
        $builder = $payload->getBuilder();

        if ($builder instanceof Clause\GroupByClauseInterface && $builder->getGroupByClauses()) {
            $newSQL = 'GROUP BY ' . implode(', ', $builder->getGroupByClauses());
            $payload = $payload->appendSQL($newSQL);
        }

        if ($builder instanceof Clause\GroupByClauseInterface && $builder->isGroupByWithRollUp()) {
            $payload = $payload->appendSQL('WITH ROLLUP');
        }

        return $payload;
    }

    /**
     * @param CompilerPayload $payload
     *
     * @return CompilerPayload
     */
    public function compileHaving(CompilerPayload $payload)
    {
        $builder = $payload->getBuilder();

        if ($builder instanceof Clause\HavingClauseInterface && $builder->getHavingClauses()) {
            $newSQL = 'HAVING ' . implode(' AND ', $builder->getHavingClauses());
            $payload = $payload->appendSQL($newSQL);
        }

        return $payload;
    }

    /**
     * @param CompilerPayload $payload
     *
     * @return CompilerPayload
     */
    public function compileOrderBy(CompilerPayload $payload)
    {
        $builder = $payload->getBuilder();

        if ($builder instanceof Clause\OrderByClauseInterface && $builder->getOrderByClauses()) {
            $newSQL = 'ORDER BY ' . implode(', ', $builder->getOrderByClauses());
            $payload = $payload->appendSQL($newSQL);
        }

        return $payload;
    }

    /**
     * @param CompilerPayload $payload
     *
     * @return CompilerPayload
     */
    public function compileLimit(CompilerPayload $payload)
    {
        $builder = $payload->getBuilder();

        if ($builder instanceof Clause\LimitClauseInterface && $builder->getLimitClause()) {
            $newSQL = 'LIMIT ' . $builder->getLimitClause();
            $payload = $payload->appendSQL($newSQL);
        }

        return $payload;
    }

    /**
     * @param CompilerPayload $payload
     *
     * @return CompilerPayload
     */
    public function compileSet(CompilerPayload $payload)
    {
        $builder = $payload->getBuilder();

        if ($builder instanceof Clause\SetClauseInterface && $builder->getSetClauses()) {
            $newSQL = 'SET ' . implode(', ', $builder->getSetClauses());
            $payload = $payload->appendSQL($newSQL);
        }

        return $payload;
    }
}