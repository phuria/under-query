<?php

namespace Phuria\QueryBuilder\Compiler;

use Phuria\QueryBuilder\QueryBuilder;

/**
 * @author Beniamin Jonatan Šimko <spam@simko.it>
 */
interface QueryCompilerInterface
{
    /**
     * @param QueryBuilder $qb
     *
     * @return boolean
     */
    public function canHandleQuery(QueryBuilder $qb);

    /**
     * @param QueryBuilder $qb
     *
     * @return string
     */
    public function compile(QueryBuilder $qb);
}