<?php

namespace Phuria\QueryBuilder\Compiler;

use Phuria\QueryBuilder\QueryBuilder;

/**
 * @author Beniamin Jonatan Šimko <spam@simko.it>
 */
interface CompilerInterface
{
    /**
     * @param QueryBuilder $qb
     *
     * @return string
     */
    public function compile(QueryBuilder $qb);
}