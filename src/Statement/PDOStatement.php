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
 */
class PDOStatement extends AbstractStatement
{
    /**
     * @var \PDOStatement
     */
    private $wrappedStatement;

    /**
     * @param \PDOStatement $stmt
     */
    public function __construct(\PDOStatement $stmt)
    {
        $this->wrappedStatement = $stmt;
    }

    /**
     * @return \PDOStatement
     */
    public function getWrappedStatement()
    {
        return $this->wrappedStatement;
    }

    /**
     * @inheritdoc
     */
    public function bindParameter(QueryParameterInterface $parameter)
    {
        $this->bindValue($parameter->getName(), $parameter->getValue());

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function bindValue($name, $value)
    {
        $this->wrappedStatement->bindValue($name, $value);

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function execute()
    {
        $this->wrappedStatement->execute();

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function rowCount()
    {
        return $this->wrappedStatement->rowCount();
    }

    /**
     * @inheritdoc
     */
    public function closeCursor()
    {
        $this->wrappedStatement->closeCursor();

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function fetch($fetchStyle = null, $cursorOrientation = \PDO::FETCH_ORI_NEXT, $cursorOffset = 0)
    {
        return $this->wrappedStatement->fetch($fetchStyle, $cursorOrientation, $cursorOffset);
    }

    /**
     * @inheritdoc
     */
    public function fetchColumn($column = 0)
    {
        return $this->wrappedStatement->fetchColumn($column);
    }

    /**
     * @inheritdoc
     */
    public function fetchAll($fetchStyle = null)
    {
        return $this->fetchAll($fetchStyle);
    }

    /**
     * @inheritdoc
     */
    public function fetchObject($className = 'stdClass', $constructorArguments = [])
    {
        return $this->fetchObject($className, $constructorArguments);
    }

    /**
     * @inheritdoc
     */
    public function fetchCallback(callable $callback)
    {
        return $this->wrappedStatement->fetchAll(\PDO::FETCH_FUNC, $callback);
    }
}