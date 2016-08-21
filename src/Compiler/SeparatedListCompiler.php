<?php

/**
 * This file is part of Phuria SQL Builder package.
 *
 * Copyright (c) 2016 Beniamin Jonatan Šimko
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

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