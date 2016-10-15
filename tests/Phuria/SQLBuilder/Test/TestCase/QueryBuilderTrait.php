<?php

/**
 * This file is part of Phuria SQL Builder package.
 *
 * Copyright (c) 2016 Beniamin Jonatan Šimko
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Phuria\SQLBuilder\Test\TestCase;

use Phuria\SQLBuilder\QueryBuilderFactory;

/**
 * @author Beniamin Jonatan Šimko <spam@simko.it>
 */
trait QueryBuilderTrait
{
    /**
     * @var QueryBuilderFactory
     */
    protected static $qb;

    /**
     * @return QueryBuilderFactory
     */
    protected static function queryBuilder()
    {
        if (null === static::$qb) {
            static::$qb = new QueryBuilderFactory();
        }

        return static::$qb;
    }
}