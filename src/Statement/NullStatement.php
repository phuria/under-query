<?php

/**
 * This file is part of UnderQuery package.
 *
 * Copyright (c) 2016 Beniamin Jonatan Šimko
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Phuria\UnderQuery\Statement;

use Phuria\UnderQuery\Parameter\QueryParameterInterface;

/**
 * @author Beniamin Jonatan Šimko <spam@simko.it>
 * @codeCoverageIgnore
 */
class NullStatement implements StatementInterface
{
    /**
     * @inheritdoc
     */
    public function execute()
    {
        return $this;
    }

    /**
     * @inheritdoc
     */
    public function rowCount()
    {
        return null;
    }

    /**
     * @inheritdoc
     */
    public function bindParameter(QueryParameterInterface $parameter)
    {
        return $this;
    }

    /**
     * @inheritdoc
     */
    public function bindParameters($parameters)
    {
        return $this;
    }

    /**
     * @inheritdoc
     */
    public function bindValue($name, $value)
    {
        return $this;
    }

    /**
     * @inheritdoc
     */
    public function closeCursor()
    {
        return $this;
    }

    /**
     * @inheritdoc
     */
    public function fetch($fetchStyle = null, $cursorOrientation = \PDO::FETCH_ORI_NEXT, $cursorOffset = 0)
    {
        return null;
    }

    /**
     * @inheritdoc
     */
    public function fetchColumn($column = 0)
    {
        return null;
    }

    /**
     * @inheritdoc
     */
    public function fetchAll($fetchStyle = null)
    {
        return [];
    }

    /**
     * @inheritdoc
     */
    public function fetchObject($className = 'stdClass', $constructorArguments = [])
    {
        return null;
    }

    /**
     * @inheritdoc
     */
    public function fetchCallback(callable $callback)
    {
        return null;
    }
}