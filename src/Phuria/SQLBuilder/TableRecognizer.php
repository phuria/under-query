<?php

/**
 * This file is part of Phuria SQL Builder package.
 *
 * Copyright (c) 2016 Beniamin Jonatan Šimko
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Phuria\SQLBuilder;

/**
 * @author Beniamin Jonatan Šimko <spam@simko.it>
 */
class TableRecognizer
{
    const TYPE_CLOSURE = 1;
    const TYPE_CLASS_NAME = 2;
    const TYPE_TABLE_NAME = 3;
    const TYPE_SUB_QUERY = 4;

    /**
     * @param mixed $stuff
     *
     * @return int
     */
    public function recognizeType($stuff)
    {
        switch (true) {
            case $stuff instanceof \Closure:
                return static::TYPE_CLOSURE;
            case $stuff instanceof QueryBuilder:
                return static::TYPE_SUB_QUERY;
            case false !== strpos($stuff, '\\'):
                return static::TYPE_CLASS_NAME;
        }

        return static::TYPE_TABLE_NAME;
    }

    /**
     * @param \Closure $closure
     *
     * @return string
     */
    public function extractClassName(\Closure $closure)
    {
        $ref = new \ReflectionFunction($closure);
        $firstParameter = $ref->getParameters()[0];

        return $firstParameter->getClass()->getName();
    }
}