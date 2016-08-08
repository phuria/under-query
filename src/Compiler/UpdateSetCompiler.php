<?php

namespace Phuria\QueryBuilder\Compiler;

use Phuria\QueryBuilder\QueryBuilder;

/**
 * @author Beniamin Jonatan Šimko <spam@simko.it>
 */
class UpdateSetCompiler extends AbstractCompiler
{
    /**
     * @inheritdoc
     */
    public function compile(QueryBuilder $qb)
    {
        return implode(', ', $this->compileExpressionList($qb->getSetClauses()));
    }
}