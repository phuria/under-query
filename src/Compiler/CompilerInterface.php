<?php

namespace Phuria\QueryBuilder\Compiler;

/**
 * @author Beniamin Jonatan Šimko <spam@simko.it>
 */
interface CompilerInterface
{
    /**
     * @param mixed $stuff
     *
     * @return mixed
     */
    public function compile($stuff);
}