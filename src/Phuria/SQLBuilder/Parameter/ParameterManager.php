<?php

/**
 * This file is part of Phuria SQL Builder package.
 *
 * Copyright (c) 2016 Beniamin Jonatan Šimko
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Phuria\SQLBuilder\Parameter;

/**
 * @author Beniamin Jonatan Šimko <spam@simko.it>
 */
class ParameterManager implements ParameterManagerInterface
{
    /**
     * @var QueryParameter[]
     */
    private $parameters = [];

    /**
     * @var array
     */
    private $references = [];

    /**
     * @var int
     */
    private $referenceCounter = 0;

    /**
     * @inheritdoc
     */
    public function createOrGetParameter($name)
    {
        if (false === array_key_exists($name, $this->parameters)) {
            $this->parameters[$name] = new QueryParameter($name);
        }

        return $this->parameters[$name];
    }

    /**
     * @return QueryParameter[]
     */
    public function toArray()
    {
        return $this->parameters;
    }

    /**
     * @param mixed $value
     *
     * @return string
     */
    public function createReference($value)
    {
        $ref = $this->generateNextReference();
        $this->references[$ref] = $value;

        return $ref;
    }

    /**
     * @return array
     */
    public function getReferences()
    {
        return $this->references;
    }

    /**
     * @return string
     */
    private function generateNextReference()
    {
        return sprintf('@[%d]', $this->referenceCounter++);
    }
}