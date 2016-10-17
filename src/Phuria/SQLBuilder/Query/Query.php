<?php

/**
 * This file is part of Phuria SQL Builder package.
 *
 * Copyright (c) 2016 Beniamin Jonatan Šimko
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Phuria\SQLBuilder\Query;

use Phuria\SQLBuilder\Connection\ConnectionInterface;
use Phuria\SQLBuilder\Parameter\ParameterManagerInterface;

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
     * @var ParameterManagerInterface
     */
    private $parameterManager;

    /**
     * @var ConnectionInterface
     */
    private $connection;

    /**
     * @param string                    $sql
     * @param ParameterManagerInterface $parameterManager
     * @param ConnectionInterface       $connection
     */
    public function __construct(
        $sql,
        ParameterManagerInterface $parameterManager,
        ConnectionInterface $connection
    ) {
        $this->sql = $sql;
        $this->parameterManager = $parameterManager;
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
        return $this->connection->fetchScalar($this->sql, $this->parameterManager->toArray());
    }

    /**
     * @return array
     */
    public function fetchRow()
    {
        return $this->connection->fetchRow($this->sql, $this->parameterManager->toArray());
    }

    /**
     * @return array
     */
    public function fetchAll()
    {
        return $this->connection->fetchAll($this->sql, $this->parameterManager->toArray());
    }

    /**
     * @return int
     */
    public function rowCount()
    {
        return $this->connection->rowCount($this->sql, $this->parameterManager->toArray());
    }

    /**
     * @return int
     */
    public function execute()
    {
        return $this->connection->execute($this->sql, $this->parameterManager->toArray());
    }

    /**
     * @param int|string $name
     * @param mixed      $value
     *
     * @return $this
     */
    public function setParameter($name, $value)
    {
        $this->parameterManager->getParameter($name)->setValue($value);

        return $this;
    }

    /**
     * @return ParameterManagerInterface
     */
    public function getParameterManager()
    {
        return $this->parameterManager;
    }

    /**
     * @return ConnectionInterface
     */
    public function getConnection()
    {
        return $this->connection;
    }
}