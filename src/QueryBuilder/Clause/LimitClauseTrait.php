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
trait LimitClauseTrait
{
    /**
     * @var string $limitClause
     */
    private $limitClause;

    /**
     * @return string
     */
    public function getLimitClause()
    {
        return $this->limitClause;
    }

    /**
     * @param string $limitClause
     *
     * @return $this
     */
    public function setLimit($limitClause)
    {
        $this->limitClause = $limitClause;

        return $this;
    }
}