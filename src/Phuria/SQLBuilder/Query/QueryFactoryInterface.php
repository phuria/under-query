<?php

/**
 * This file is part of Phuria SQL Builder package.
 *
 * Copyright (c) 2016 Beniamin Jonatan Šimko
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Phuria\SQLBuilder\Query;

use Phuria\SQLBuilder\Parameter\ParameterManagerInterface;

/**
 * @author Beniamin Jonatan Šimko <spam@simko.it>
 */
interface QueryFactoryInterface
{
    /**
     * @param string                    $SQL
     * @param ParameterManagerInterface $parameterManager
     * @param mixed                     $connectionHint
     *
     * @return Query
     */
    public function buildQuery($SQL, ParameterManagerInterface $parameterManager, $connectionHint = null);
}