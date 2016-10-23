<?php

/**
 * This file is part of Phuria SQL Builder package.
 *
 * Copyright (c) 2016 Beniamin Jonatan Šimko
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Phuria\SQLBuilder\QueryCompiler\ConcreteCompiler;

use Phuria\SQLBuilder\QueryBuilder\AbstractInsertBuilder;
use Phuria\SQLBuilder\QueryBuilder\BuilderInterface;
use Phuria\SQLBuilder\QueryBuilder\InsertBuilder;
use Phuria\SQLBuilder\QueryBuilder\InsertSelectBuilder;
use Phuria\SQLBuilder\QueryCompiler\CompilerPayload;
use Phuria\SQLBuilder\QueryCompiler\ReferenceCompiler;
use Phuria\SQLBuilder\QueryCompiler\TableCompiler;

/**
 * @author Beniamin Jonatan Šimko <spam@simko.it>
 */
class InsertCompiler extends AbstractConcreteCompiler
{
    /**
     * InsertCompiler constructor.
     */
    public function __construct()
    {
        $tableCompiler = new TableCompiler();
        $referenceCompiler = new ReferenceCompiler();

        parent::__construct([
            [$this, 'compileInsert'],
            [$tableCompiler, 'compileRootTables'],
            [$tableCompiler, 'compileJoinTables'],
            [$this, 'compileInsertColumns'],
            [$this, 'compileSelectForInsert'],
            [$this, 'compileInsertValues'],
            [$referenceCompiler, 'compileReference'],
        ]);
    }

    /**
     * @param BuilderInterface $builder
     *
     * @return bool
     */
    public function supportsBuilder(BuilderInterface $builder)
    {
        return $builder instanceof AbstractInsertBuilder;
    }

    /**
     * @param CompilerPayload $payload
     *
     * @return CompilerPayload
     */
    public function compileInsert(CompilerPayload $payload)
    {
        $builder = $payload->getBuilder();

        if ($builder instanceof AbstractInsertBuilder) {
            $actualSQL = 'INSERT INTO';
            $payload = $payload->updateSQL($actualSQL);
        }

        return $payload;
    }

    /**
     * @param CompilerPayload $payload
     *
     * @return CompilerPayload
     */
    public function compileInsertColumns(CompilerPayload $payload)
    {
        $builder = $payload->getBuilder();

        if ($builder instanceof AbstractInsertBuilder) {
            $newSQL = '(' . implode(', ', $builder->getColumns()) . ')';
            $payload = $payload->appendSQL($newSQL);
        }

        return $payload;
    }

    /**
     * @param CompilerPayload $payload
     *
     * @return CompilerPayload
     */
    public function compileInsertValues(CompilerPayload $payload)
    {
        $builder = $payload->getBuilder();

        if ($builder instanceof InsertBuilder) {
            $newSQL = 'VALUES ' . implode(', ', array_map(function (array $values) {
                return '('. implode(', ', $values) . ')';
            }, $builder->getValues()));
            $payload = $payload->appendSQL($newSQL);
        }

        return $payload;
    }

    /**
     * @param CompilerPayload $payload
     *
     * @return CompilerPayload
     */
    public function compileSelectForInsert(CompilerPayload $payload)
    {
        $builder = $payload->getBuilder();

        if ($builder instanceof InsertSelectBuilder) {
            $newSQL = $builder->getSelectInsert()->buildSQL();
            $payload = $payload->appendSQL($newSQL);
        }

        return $payload;
    }
}