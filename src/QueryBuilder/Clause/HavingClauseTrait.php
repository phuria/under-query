<?php

/**
 * This file is part of Phuria SQL Builder package.
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
trait HavingClauseTrait
{
    /**
     * @var array $havingClauses
     */
    private $havingClauses = [];

    /**
     * @param string $clause
     *
     * @return $this
     */
    public function andHaving($clause)
    {
        $this->havingClauses[] = $clause;

        return $this;
    }

    /**
     * @return array
     */
    public function getHavingClauses()
    {
        return $this->havingClauses;
    }
}