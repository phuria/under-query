<?php

/**
 * This file is part of Phuria SQL Builder package.
 *
 * Copyright (c) 2016 Beniamin Jonatan Šimko
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Phuria\UnderQuery\Query;

use Phuria\UnderQuery\Connection\ConnectionInterface;
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
     * @var ConnectionInterface
     */
    private $connection;

    /**
     * @param string                       $sql
     * @param ParameterCollectionInterface $parameterCollection
     * @param ConnectionInterface          $connection
     */
    public function __construct(
        $sql,
        ParameterCollectionInterface $parameterCollection,
        ConnectionInterface $connection
    ) {
        $this->sql = $sql;
        $this->parameterCollection = $parameterCollection;
        $this->connection = $connection;
    }

    /**
     * @return string
     */
    public function getSQL()
    {
        return $this->sql;
    }

    /**
     * @return mixed
     */
    public function fetchScalar()
    {
        return $this->connection->fetchScalar($this->sql, $this->parameterCollection->toArray());
    }

    /**
     * @return array
     */
    public function fetchRow()
    {
        return $this->connection->fetchRow($this->sql, $this->parameterCollection->toArray());
    }

    /**
     * @return array
     */
    public function fetchAll()
    {
        return $this->connection->fetchAll($this->sql, $this->parameterCollection->toArray());
    }

    /**
     * @return int
     */
    public function rowCount()
    {
        return $this->connection->rowCount($this->sql, $this->parameterCollection->toArray());
    }

    /**
     * @return int
     */
    public function execute()
    {
        return $this->connection->execute($this->sql, $this->parameterCollection->toArray());
    }

    /**
     * @return ParameterCollectionInterface
     */
    public function getParameterCollection()
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
        $this->getParameterCollection()->getParameter($name)->setValue($value);

        return $this;
    }

    /**
     * @return ConnectionInterface
     */
    public function getConnection()
    {
        return $this->connection;
    }
}