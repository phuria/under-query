<?php

/**
 * This file is part of UnderQuery package.
 *
 * Copyright (c) 2016 Beniamin Jonatan Šimko
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Phuria\UnderQuery\Utils;

/**
 * @author Beniamin Jonatan Šimko <spam@simko.it>
 */
class RecursiveArgs
{
    /**
     * @param array    $args
     * @param callable $resolver
     */
    public static function each(array $args, callable $resolver)
    {
        foreach ($args as $arg) {
            if (is_array($arg)) {
                static::each($arg, $resolver);
            } else {
                $resolver($arg);
            }
        }
    }

    /**
     * @param array    $args
     * @param callable $resolver
     *
     * @return array
     */
    public static function map(array $args, callable $resolver)
    {
        $collection = [];

        static::each($args, function ($arg) use (&$collection, $resolver) {
            $collection[] = $resolver($arg);
        });

        return $collection;
    }
}