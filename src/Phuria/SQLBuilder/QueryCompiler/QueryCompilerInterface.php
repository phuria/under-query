<?php

namespace Phuria\SQLBuilder\QueryCompiler;

use Phuria\SQLBuilder\QueryBuilder\BuilderInterface;

/**
 * @author Beniamin Jonatan Šimko <spam@simko.it>
 */
interface QueryCompilerInterface
{
    /**
     * @param BuilderInterface $qb
     *
     * @return string
     */
    public function compile(BuilderInterface $qb);
}