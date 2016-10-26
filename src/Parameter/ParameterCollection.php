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
class ParameterCollection implements ParameterCollectionInterface
{
    private $parameters;

    /**
     * @param array $parameters
     */
    public function __construct(array $parameters = [])
    {
        $this->parameters = $parameters;
    }

    /**
     * @inheritdoc
     */
    public function __clone()
    {
        $this->parameters = $this->cloneParameters();
    }

    /**
     * @return QueryParameterInterface[]
     */
    private function cloneParameters()
    {
        $params = [];

        foreach ($this->parameters as $key => $param) {
            $params[$key] = clone $param;
        }

        return $params;
    }

    /**
     * @inheritdoc
     */
    public function toArray()
    {
        return array_values($this->cloneParameters());
    }

    /**
     * @inheritdoc
     */
    public function getParameter($name)
    {
        if (false === array_key_exists($name, $this->parameters)) {
            $this->parameters[$name] = new QueryParameter($name);
        }

        return $this->parameters[$name];
    }
}