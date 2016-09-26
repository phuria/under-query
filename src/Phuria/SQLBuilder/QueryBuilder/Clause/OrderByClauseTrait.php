<?php

/**
 * This file is part of Phuria SQL Builder package.
 *
 * Copyright (c) 2016 Beniamin Jonatan Šimko
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Phuria\SQLBuilder\QueryBuilder\Clause;

/**
 * @author Beniamin Jonatan Šimko <spam@simko.it>
 */
trait OrderByClauseTrait
{
    /**
     * @var array $orderByClauses
     */
    private $orderByClauses = [];

    /**
     * @param string $clause
     *
     * @return $this
     */
    public function addOrderBy($clause)
    {
        $this->orderByClauses[] = $clause;

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