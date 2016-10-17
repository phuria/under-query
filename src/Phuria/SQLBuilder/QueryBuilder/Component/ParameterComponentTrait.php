<?php

/**
 * This file is part of Phuria SQL Builder package.
 *
 * Copyright (c) 2016 Beniamin Jonatan Šimko
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Phuria\SQLBuilder\QueryBuilder\Component;

use Phuria\SQLBuilder\Parameter\ParameterManagerInterface;

/**
 * @author Beniamin Jonatan Šimko <spam@simko.it>
 */
trait ParameterComponentTrait
{
    /**
     * @return ParameterManagerInterface
     */
    abstract public function getParameterManager();

    /**
     * @param int|string $name
     * @param mixed      $value
     *
     * @return $this
     */
    public function setParameter($name, $value)
    {
        $this->getParameterManager()->getParameter($name)->setValue($value);

        return $this;
    }
}