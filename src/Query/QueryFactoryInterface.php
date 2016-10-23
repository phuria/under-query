<?php

/**
 * This file is part of Phuria SQL Builder package.
 *
 * Copyright (c) 2016 Beniamin Jonatan Šimko
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Phuria\UnderQuery\Query;

use Phuria\UnderQuery\Parameter\QueryParameterInterface;

/**
 * @author Beniamin Jonatan Šimko <spam@simko.it>
 */
interface QueryFactoryInterface
{
    /**
     * @param string                    $SQL
     * @param QueryParameterInterface[] $parameters
     * @param mixed                     $connectionHint
     *
     * @return Query
     */
    public function buildQuery($SQL, array $parameters, $connectionHint = null);
}