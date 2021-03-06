<?php

/**
 * This file is part of UnderQuery package.
 *
 * Copyright (c) 2016 Beniamin Jonatan Šimko
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Phuria\UnderQuery\Parameter;

/**
 * @author Beniamin Jonatan Šimko <spam@simko.it>
 */
interface ParameterCollectionInterface
{
    /**
     * @param string $name
     *
     * @return QueryParameterInterface
     */
    public function getParameter($name);

    /**
     * @param string $parameterName
     * @param mixed  $value
     *
     * @return $this
     */
    public function setValue($parameterName, $value);

    /**
     * @return QueryParameterInterface[]
     */
    public function toArray();
}