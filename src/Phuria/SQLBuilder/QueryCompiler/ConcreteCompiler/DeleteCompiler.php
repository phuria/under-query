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

use Phuria\SQLBuilder\QueryBuilder\BuilderInterface;
use Phuria\SQLBuilder\QueryBuilder\DeleteBuilder;
use Phuria\SQLBuilder\QueryCompiler\ClausesCompiler;
use Phuria\SQLBuilder\QueryCompiler\CompilerPayload;
use Phuria\SQLBuilder\QueryCompiler\ReferenceCompiler;
use Phuria\SQLBuilder\QueryCompiler\TableCompiler;

/**
 * @author Beniamin Jonatan Šimko <spam@simko.it>
 */
class DeleteCompiler extends AbstractConcreteCompiler
{
    /**
     * DeleteCompiler constructor.
     */
    public function __construct()
    {
        $tableCompiler = new TableCompiler();
        $referenceCompiler = new ReferenceCompiler();
        $clauseCompiler = new ClausesCompiler();

        parent::__construct([
            [$this, 'compileDelete'],
            [$tableCompiler, 'compileRootTables'],
            [$tableCompiler, 'compileJoinTables'],
            [$clauseCompiler, 'compileWhere'],
            [$clauseCompiler, 'compileOrderBy'],
            [$clauseCompiler, 'compileLimit'],
            [$referenceCompiler, 'compileReference'],
        ]);
    }

    /**
     * @inheritdoc
     */
    public function supportsBuilder(BuilderInterface $builder)
    {
        return $builder instanceof DeleteBuilder;
    }

    /**
     * @param CompilerPayload $payload
     *
     * @return CompilerPayload
     */
    public function compileDelete(CompilerPayload $payload)
    {
        $builder = $payload->getBuilder();

        if ($builder instanceof DeleteBuilder) {
            $payload = $payload->updateSQL('DELETE');
        }

        if ($builder instanceof DeleteBuilder && $builder->getDeleteClauses()) {
            $newSQL = implode(', ', $builder->getDeleteClauses());
            $payload = $payload->appendSQL($newSQL);
        }

        return $payload;
    }
}