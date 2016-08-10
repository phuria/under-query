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
     * @return string
     */
    public function compile($stuff);
}