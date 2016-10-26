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

/**
 * @author Beniamin Jonatan Šimko <spam@simko.it>
 */
trait WhereClauseTrait
{
    /**
     * @var array
     */
    private $whereClauses = [];

    /**
     * @param string $clause
     *
     * @return $this
     */
    public function andWhere($clause)
    {
        $this->whereClauses[] = $clause;

        return $this;
    }

    /**
     * @return array
     */
    public function getWhereClauses()
    {
        return $this->whereClauses;
    }
}