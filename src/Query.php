<?php

namespace Phuria\QueryBuilder;

use Phuria\QueryBuilder\Connection\ConnectionInterface;
use Phuria\QueryBuilder\Parameter\ParameterManagerInterface;
use Phuria\QueryBuilder\Statement\StatementInterface;

/**
 * @author Beniamin Jonatan Šimko <spam@simko.it>
 */
class Query
{
    /**
     * @var string $sql
     */
    private $sql;

    /**
     * @var ParameterManagerInterface $parameterManager
     */
    private $parameterManager;

    /**
     * @var ConnectionInterface $connection
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
        ConnectionInterface $connection = null
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
     * @return StatementInterface
     */
    public function buildStatement()
    {
        $stmt = $this->connection->prepare($this->sql);
        $this->parameterManager->bindStatement($stmt);

        return $stmt;
    }

    /**
     * @return mixed
     */
    public function fetchScalar()
    {
        $stmt = $this->buildStatement();
        $stmt->execute();

        return $stmt->fetchScalar();
    }

    /**
     * @param int|string $name
     * @param mixed      $value
     *
     * @return $this
     */
    public function setParameter($name, $value)
    {
        $this->parameterManager->createOrGetParameter($name)->setValue($value);

        return $this;
    }
}