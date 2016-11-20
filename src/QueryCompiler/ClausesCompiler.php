<?php

/**
 * This file is part of UnderQuery package.
 *
 * Copyright (c) 2016 Beniamin Jonatan Šimko
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Phuria\UnderQuery\QueryCompiler;

use Phuria\UnderQuery\QueryBuilder\Clause;

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

        if ($builder instanceof Clause\WhereInterface && $builder->getWhereClauses()) {
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

        if ($builder instanceof Clause\GroupByInterface && $builder->getGroupByClauses()) {
            $newSQL = 'GROUP BY ' . implode(', ', $builder->getGroupByClauses());
            $payload = $payload->appendSQL($newSQL);
        }

        if ($builder instanceof Clause\GroupByInterface && $builder->isGroupByWithRollUp()) {
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

        if ($builder instanceof Clause\HavingInterface && $builder->getHavingClauses()) {
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

        if ($builder instanceof Clause\OrderByInterface && $builder->getOrderByClauses()) {
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

        if ($builder instanceof Clause\LimitInterface && $builder->getLimitClause()) {
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

        if ($builder instanceof Clause\SetInterface && $builder->getSetClauses()) {
            $newSQL = 'SET ' . implode(', ', $builder->getSetClauses());
            $payload = $payload->appendSQL($newSQL);
        }

        return $payload;
    }

    /**
     * @param CompilerPayload $payload
     *
     * @return CompilerPayload
     */
    public function compileSelect(CompilerPayload $payload)
    {
        $builder = $payload->getBuilder();

        if ($builder instanceof Clause\SelectInterface && $builder->getSelectClauses()) {
            $actualSQL = 'SELECT ' . implode(', ', $builder->getSelectClauses());
            $payload = $payload->updateSQL($actualSQL);
        }

        return $payload;
    }
}