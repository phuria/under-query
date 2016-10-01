<?php

namespace Phuria\SQLBuilder\QueryCompiler;

use Phuria\SQLBuilder\QueryBuilder\BuilderInterface;

/**
 * @author Beniamin Jonatan Šimko <spam@simko.it>
 */
interface QueryCompilerInterface
{
    /**
     * @param BuilderInterface $builder
     *
     * @return string
     */
    public function compile(BuilderInterface $builder);
}