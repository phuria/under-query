<?php

/**
 * This file is part of Phuria SQL Builder package.
 *
 * Copyright (c) 2016 Beniamin Jonatan Šimko
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Phuria\UnderQuery\QueryCompiler\ConcreteCompiler;

use Phuria\UnderQuery\QueryBuilder\BuilderInterface;
use Phuria\UnderQuery\QueryBuilder\DeleteBuilder;
use Phuria\UnderQuery\QueryCompiler\ClausesCompiler;
use Phuria\UnderQuery\QueryCompiler\CompilerPayload;
use Phuria\UnderQuery\QueryCompiler\ReferenceCompiler;
use Phuria\UnderQuery\QueryCompiler\TableCompiler;

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