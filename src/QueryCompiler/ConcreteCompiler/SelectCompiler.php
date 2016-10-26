<?php

/**
 * This file is part of UnderQuery package.
 *
 * Copyright (c) 2016 Beniamin Jonatan Šimko
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Phuria\UnderQuery\QueryCompiler\ConcreteCompiler;

use Phuria\UnderQuery\QueryBuilder\BuilderInterface;
use Phuria\UnderQuery\QueryBuilder\SelectBuilder;
use Phuria\UnderQuery\QueryCompiler\ClausesCompiler;
use Phuria\UnderQuery\QueryCompiler\CompilerPayload;
use Phuria\UnderQuery\QueryCompiler\ReferenceCompiler;
use Phuria\UnderQuery\QueryCompiler\TableCompiler;

/**
 * @author Beniamin Jonatan Šimko <spam@simko.it>
 */
class SelectCompiler extends AbstractConcreteCompiler
{
    /**
     * SelectCompiler constructor.
     */
    public function __construct()
    {
        $tableCompiler = new TableCompiler();
        $referenceCompiler = new ReferenceCompiler();
        $clauseCompiler = new ClausesCompiler();

        parent::__construct([
            [$this, 'compileSelect'],
            [$tableCompiler, 'compileRootTables'],
            [$tableCompiler, 'compileJoinTables'],
            [$clauseCompiler, 'compileWhere'],
            [$clauseCompiler, 'compileGroupBy'],
            [$clauseCompiler, 'compileHaving'],
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
        return $builder instanceof SelectBuilder;
    }

    /**
     * @param CompilerPayload $payload
     *
     * @return CompilerPayload
     */
    public function compileSelect(CompilerPayload $payload)
    {
        $builder = $payload->getBuilder();

        if ($builder instanceof SelectBuilder) {
            $actualSQL = 'SELECT ' . implode(', ', $builder->getSelectClauses());
            $payload = $payload->updateSQL($actualSQL);
        }

        return $payload;
    }
}