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
trait SelectClauseTrait
{
    /**
     * @var array $selectClauses
     */
    private $selectClauses = [];

    /**
     * @return $this
     */
    public function addSelect()
    {
        foreach (func_get_args() as $clause) {
            $this->doAddSelect($clause);
        }

        return $this;
    }

    /**
     * @param string $clause
     */
    private function doAddSelect($clause)
    {
        $this->selectClauses[] = $clause;
    }

    /**
     * @return array
     */
    public function getSelectClauses()
    {
        return $this->selectClauses;
    }
}