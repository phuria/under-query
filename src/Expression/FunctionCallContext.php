<?php

/**
 * This file is part of Phuria SQL Builder package.
 *
 * Copyright (c) 2016 Beniamin Jonatan Šimko
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Phuria\QueryBuilder\Expression;

/**
 * @author Beniamin Jonatan Šimko <spam@simko.it>
 */
class FunctionCallContext
{
    /**
     * @var ExpressionInterface[] $callHints
     */
    private $callHints = [];

    /**
     * @param array $options
     */
    public function __construct(array $options)
    {
        $options = array_merge([
            'callHints' => []
        ], $options);

        $this->callHints = $options['callHints'];
    }

    /**
     * @return ExpressionInterface[]
     */
    public function getCallHints()
    {
        return $this->callHints;
    }
}