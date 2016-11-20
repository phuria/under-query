<?php

/**
 * This file is part of UnderQuery package.
 *
 * Copyright (c) 2016 Beniamin Jonatan Šimko
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Phuria\UnderQuery\Reference;

/**
 * @author Beniamin Jonatan Šimko <spam@simko.it>
 */
class ReferenceCollection implements ReferenceCollectionInterface
{
    /**
     * @var array
     */
    private $references = [];

    /**
     * @var int
     */
    private $referenceCounter = 0;

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
     * @inheritdoc
     */
    public function toArray()
    {
        return $this->references;
    }

    /**
     * @return string
     */
    private function generateNextReference()
    {
        return sprintf('@ref[%d]', $this->referenceCounter++);
    }
}