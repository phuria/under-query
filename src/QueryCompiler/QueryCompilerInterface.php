<?php

namespace Phuria\UnderQuery\QueryCompiler;

use Phuria\UnderQuery\QueryBuilder\BuilderInterface;

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