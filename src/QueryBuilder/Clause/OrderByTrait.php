<?php

/**
 * This file is part of UnderQuery package.
 *
 * Copyright (c) 2016 Beniamin Jonatan Šimko
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Phuria\UnderQuery\QueryBuilder\Clause;

use Phuria\UnderQuery\Utils\RecursiveArgs;

/**
 * @author Beniamin Jonatan Šimko <spam@simko.it>
 */
trait OrderByTrait
{
    /**
     * @var array $orderByClauses
     */
    private $orderByClauses = [];

    /**
     * @param mixed $_
     *
     * @return $this
     */
    public function addOrderBy($_)
    {
        RecursiveArgs::each(func_get_args(), function ($arg) {
            $this->orderByClauses[] = $arg;
        });

        return $this;
    }

    /**
     * @return array
     */
    public function getOrderByClauses()
    {
        return $this->orderByClauses;
    }
}