<?php

/**
 * This file is part of Phuria SQL Builder package.
 *
 * Copyright (c) 2016 Beniamin Jonatan Šimko
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Phuria\SQLBuilder\QueryBuilder;

/**
 * @author Beniamin Jonatan Šimko <spam@simko.it>
 */
interface BuilderInterface
{
    /**
     * @return string
     */
    public function buildSQL();

    /**
     * @param mixed $object
     *
     * @return string
     */
    public function objectToString($object);
}