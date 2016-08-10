<?php

namespace Phuria\QueryBuilder\Compiler;

/**
 * @author Beniamin Jonatan Šimko <spam@simko.it>
 */
class SeparatedListCompiler implements CompilerInterface
{
    /**
     * @var string $separator
     */
    private $separator;

    /**
     * @param string $separator
     */
    public function __construct($separator)
    {
        $this->separator = $separator;
    }

    /**
     * @inheritdoc
     */
    public function compile($stuff)
    {
        $compiled = (new ExpressionListCompiler())->compile($stuff);

        return implode($this->separator, $compiled);
    }
}