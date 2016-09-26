<?php

namespace Phuria\SQLBuilder\QueryCompiler;

use Phuria\SQLBuilder\QueryBuilder\AbstractBuilder;

/**
 * @author Beniamin Jonatan Šimko <spam@simko.it>
 */
interface QueryCompilerInterface
{
    /**
     * @param AbstractBuilder $qb
     *
     * @return string
     */
    public function compile(AbstractBuilder $qb);
}