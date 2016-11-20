<?php

/**
 * This file is part of UnderQuery package.
 *
 * Copyright (c) 2016 Beniamin Jonatan Šimko
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Phuria\UnderQuery\Table;

/**
 * @author Beniamin Jonatan Šimko <spam@simko.it>
 */
class JoinMetadata
{
    /**
     * @var string
     */
    private $joinType;

    /**
     * @var string
     */
    private $joinOn;

    /**
     * @var bool
     */
    private $naturalJoin = false;

    /**
     * @var bool
     */
    private $outerJoin = false;

    /**
     * @return string
     */
    public function getJoinType()
    {
        return $this->joinType;
    }

    /**
     * @param string $joinType
     *
     * @return JoinMetadata
     */
    public function setJoinType($joinType)
    {
        $this->joinType = $joinType;

        return $this;
    }

    /**
     * @return string
     */
    public function getJoinOn()
    {
        return $this->joinOn;
    }

    /**
     * @param string $joinOn
     *
     * @return JoinMetadata
     */
    public function setJoinOn($joinOn)
    {
        $this->joinOn = $joinOn;

        return $this;
    }

    /**
     * @return boolean
     */
    public function isNaturalJoin()
    {
        return $this->naturalJoin;
    }

    /**
     * @param boolean $naturalJoin
     *
     * @return JoinMetadata
     */
    public function setNaturalJoin($naturalJoin)
    {
        $this->naturalJoin = $naturalJoin;

        return $this;
    }

    /**
     * @return boolean
     */
    public function isOuterJoin()
    {
        return $this->outerJoin;
    }

    /**
     * @param boolean $outerJoin
     *
     * @return JoinMetadata
     */
    public function setOuterJoin($outerJoin)
    {
        $this->outerJoin = $outerJoin;

        return $this;
    }
}