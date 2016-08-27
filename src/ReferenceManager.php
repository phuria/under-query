<?php

/**
 * This file is part of Phuria SQL Builder package.
 *
 * Copyright (c) 2016 Beniamin Jonatan Šimko
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Phuria\QueryBuilder;

/**
 * @author Beniamin Jonatan Šimko <spam@simko.it>
 */
class ReferenceManager
{
    /**
     * @var array $references
     */
    private $references = [];

    /**
     * @var int $referenceCounter
     */
    private $referenceCounter = 0;

    /**
     * @param mixed $value
     *
     * @return string
     */
    public function register($value)
    {
        $ref = $this->generateNextReference();
        $this->references[$ref] = $value;

        return $ref;
    }

    /**
     * @return array
     */
    public function all()
    {
        return $this->references;
    }

    /**
     * @return string
     */
    private function generateNextReference()
    {
        return sprintf('@%d@', $this->referenceCounter++);
    }
}