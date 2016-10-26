<?php

/**
 * This file is part of UnderQuery package.
 *
 * Copyright (c) 2016 Beniamin Jonatan Šimko
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Phuria\UnderQuery\Query;

use Phuria\UnderQuery\Parameter\ParameterCollection;
use Phuria\UnderQuery\Parameter\ParameterCollectionInterface;

/**
 * @author Beniamin Jonatan Šimko <spam@simko.it>
 */
class Query
{
    /**
     * @var string
     */
    private $sql;

    /**
     * @var ParameterCollectionInterface
     */
    private $parameterCollection;

    /**
     * @param string $sql
     * @param array  $parameters
     */
    public function __construct($sql, array $parameters = [])
    {
        $this->sql = $sql;
        $this->parameterCollection = new ParameterCollection($parameters);
    }

    /**
     * @return string
     */
    public function getSQL()
    {
        return $this->sql;
    }

    /**
     * @return ParameterCollectionInterface
     */
    public function getParameters()
    {
        return $this->parameterCollection;
    }

    /**
     * @param int|string $name
     * @param mixed      $value
     *
     * @return $this
     */
    public function setParameter($name, $value)
    {
        $this->getParameters()->getParameter($name)->setValue($value);

        return $this;
    }
}