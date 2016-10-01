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
use Phuria\SQLBuilder\QueryBuilder\UpdateBuilder;
use Phuria\SQLBuilder\QueryCompiler\ClausesCompiler;
use Phuria\SQLBuilder\QueryCompiler\CompilerPayload;
use Phuria\SQLBuilder\QueryCompiler\ReferenceCompiler;
use Phuria\SQLBuilder\QueryCompiler\TableCompiler;

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
            [$this,              'compileUpdate'],
            [$tableCompiler,     'compileRootTables'],
            [$tableCompiler,     'compileJoinTables'],
            [$clauseCompiler,    'compileSet'],
            [$clauseCompiler,    'compileWhere'],
            [$clauseCompiler,    'compileOrderBy'],
            [$clauseCompiler,    'compileLimit'],
            [$referenceCompiler, 'compileReference']
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