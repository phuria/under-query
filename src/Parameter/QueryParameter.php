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
class QueryParameter implements QueryParameterInterface
{
    /**
     * @var $name
     */
    private $name;

    /**
     * @var $value
     */
    private $value;

    /**
     * @param string $name
     */
    public function __construct($name)
    {
        $this->name = $name;
    }

    /**
     * @inheritdoc
     */
    public function setValue($value)
    {
        $this->value = $value;

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @inheritdoc
     */
    public function getValue()
    {
        return $this->value;
    }
}