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
trait SelectTrait
{
    /**
     * @var array $selectClauses
     */
    private $selectClauses = [];

    /**
     * @param mixed $_
     *
     * @return $this
     */
    public function addSelect($_)
    {
        RecursiveArgs::each(func_get_args(), function ($arg) {
           $this->selectClauses[] = $arg;
        });

        return $this;
    }

    /**
     * @return array
     */
    public function getSelectClauses()
    {
        return $this->selectClauses;
    }
}