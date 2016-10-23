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
use Phuria\UnderQuery\QueryBuilder\UpdateBuilder;
use Phuria\UnderQuery\QueryCompiler\ClausesCompiler;
use Phuria\UnderQuery\QueryCompiler\CompilerPayload;
use Phuria\UnderQuery\QueryCompiler\ReferenceCompiler;
use Phuria\UnderQuery\QueryCompiler\TableCompiler;

/**
 * @author Beniamin Jonatan Šimko <spam@simko.it>
 */
class UpdateCompiler extends AbstractConcreteCompiler
{
    /**
     * UpdateCompiler constructor.
     */
    public function __construct()
    {
        $tableCompiler = new TableCompiler();
        $referenceCompiler = new ReferenceCompiler();
        $clauseCompiler = new ClausesCompiler();

        parent::__construct([
            [$this, 'compileUpdate'],
            [$tableCompiler, 'compileRootTables'],
            [$tableCompiler, 'compileJoinTables'],
            [$clauseCompiler, 'compileSet'],
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
        return $builder instanceof UpdateBuilder;
    }

    /**
     * @param CompilerPayload $payload
     *
     * @return CompilerPayload
     */
    public function compileUpdate(CompilerPayload $payload)
    {
        $builder = $payload->getBuilder();

        if ($builder instanceof UpdateBuilder) {
            $newSQL = $builder->isIgnore() ? 'UPDATE IGNORE' : 'UPDATE';
            $payload = $payload->updateSQL($newSQL);
        }

        return $payload;
    }
}