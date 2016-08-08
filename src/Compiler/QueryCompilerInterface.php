<?php

namespace Phuria\QueryBuilder\Compiler;

use Phuria\QueryBuilder\QueryBuilder;

/**
 * @author Beniamin Jonatan Šimko <spam@simko.it>
 */
interface QueryCompilerInterface extends CompilerInterface
{
    /**
     * @param QueryBuilder $qb
     *
     * @return boolean
     */
    public function canHandleQuery(QueryBuilder $qb);
}