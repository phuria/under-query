<?php

/**
 * This file is part of Phuria SQL Builder package.
 *
 * Copyright (c) 2016 Beniamin Jonatan Šimko
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Phuria\QueryBuilder\Expression;

/**
 * @author Beniamin Jonatan Šimko <spam@simko.it>
 */
class ExpressionCollection implements ExpressionInterface, \ArrayAccess
{
    /**
     * @var ExpressionInterface[] $expressionList
     */
    private $expressionList;

    /**
     * @var string $separator
     */
    private $separator;

    /**
     * @param array  $expressionList
     * @param string $separator
     */
    public function __construct(array $expressionList = [], $separator = '')
    {
        $this->expressionList = $expressionList;
        $this->separator = $separator;
    }

    /**
     * @return ExpressionInterface[]
     */
    public function getExpressionList()
    {
        return $this->expressionList;
    }

    /**
     * @param string $separator
     *
     * @return ExpressionCollection
     */
    public function changeSeparator($separator)
    {
        return new self($this->expressionList, $separator);
    }

    /**
     * @param ExpressionInterface $expression
     *
     * @return $this
     */
    public function addElement(ExpressionInterface $expression)
    {
        $this->expressionList[] = $expression;

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function compile()
    {
        $elements = [];

        foreach ($this->expressionList as $expression) {
            $elements[] = $expression->compile();
        }

        return implode($this->separator, $elements);
    }

    /**
     * @return bool
     */
    public function isEmpty()
    {
        return empty($this->expressionList);
    }

    /**
     * @inheritdoc
     */
    public function offsetExists($offset)
    {
        return array_key_exists($offset, $this->expressionList);
    }

    /**
     * @inheritdoc
     */
    public function offsetGet($offset)
    {
        return $this->expressionList[$offset];
    }

    /**
     * @inheritdoc
     */
    public function offsetSet($offset, $value)
    {
        $this->expressionList[$offset] = $value;

        return $value;
    }

    /**
     * @inheritdoc
     */
    public function offsetUnset($offset)
    {
        unset($this->expressionList[$offset]);
    }
}