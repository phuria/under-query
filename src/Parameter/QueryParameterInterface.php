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
interface QueryParameterInterface
{
    /**
     * @return mixed
     */
    public function getName();

    /**
     * @return mixed
     */
    public function getValue();

    /**
     * @param mixed $value
     *
     * @return QueryParameterInterface
     */
    public function setValue($value);
}