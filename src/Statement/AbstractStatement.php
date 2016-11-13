<?php

/**
 * This file is part of UnderQuery package.
 *
 * Copyright (c) 2016 Beniamin Jonatan Šimko
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Phuria\UnderQuery\Statement;

use Phuria\UnderQuery\Parameter\QueryParameterInterface;

/**
 * @author Beniamin Jonatan Šimko <spam@simko.it>
 */
abstract class AbstractStatement implements StatementInterface
{
    /**
     * @param QueryParameterInterface[] $parameters
     *
     * @return $this
     */
    public function bindParameters($parameters)
    {
        foreach ($parameters as $parameter) {
            $this->bindParameter($parameter);
        }

        return $this;
    }
}