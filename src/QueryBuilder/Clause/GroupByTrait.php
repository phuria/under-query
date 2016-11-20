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
trait GroupByTrait
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
     * @param mixed $_
     *
     * @return $this
     */
    public function addGroupBy($_)
    {
        RecursiveArgs::each(func_get_args(), function ($arg) {
            $this->groupByClauses[] = $arg;
        });

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
     *
     * @return $this
     */
    public function setGroupByWithRollUp($groupByWithRollUp)
    {
        $this->groupByWithRollUp = $groupByWithRollUp;

        return $this;
    }
}