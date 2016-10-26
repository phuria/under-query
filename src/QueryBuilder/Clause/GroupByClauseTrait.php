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
trait GroupByClauseTrait
{
    /**
     * @var bool
     */
    private $groupByWithRollUp = false;

    /**
     * @var array
     */
    private $groupByClauses = [];

    /**
     * @param string $clause
     *
     * @return $this
     */
    public function addGroupBy($clause)
    {
        $this->groupByClauses[] = $clause;

        return $this;
    }

    /**
     * @return array
     */
    public function getGroupByClauses()
    {
        return $this->groupByClauses;
    }

    /**
     * @return boolean
     */
    public function isGroupByWithRollUp()
    {
        return $this->groupByWithRollUp;
    }

    /**
     * @param boolean $groupByWithRollUp
     */
    public function setGroupByWithRollUp($groupByWithRollUp)
    {
        $this->groupByWithRollUp = $groupByWithRollUp;
    }
}