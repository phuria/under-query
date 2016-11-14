<?php

/**
 * This file is part of UnderQuery package.
 *
 * Copyright (c) 2016 Beniamin Jonatan Šimko
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Phuria\UnderQuery\Query;

use Doctrine\DBAL\Driver\Connection as ConnectionInterface;
use Phuria\UnderQuery\Parameter\ParameterCollection;
use Phuria\UnderQuery\Parameter\ParameterCollectionInterface;

/**
 * @author Beniamin Jonatan Šimko <spam@simko.it>
 */
class Query implements QueryInterface
{
    /**
     * @var string
     */
    private $compiledSQL;

    /**
     * @var ParameterCollectionInterface
     */
    private $parameterCollection;

    /**
     * @var ConnectionInterface|null
     */
    private $connection;

    /**
     * @param string                   $compiledSQL
     * @param array                    $parameters
     * @param ConnectionInterface|null $connection
     */
    public function __construct($compiledSQL, array $parameters = [], ConnectionInterface $connection = null)
    {
        $this->compiledSQL = $compiledSQL;
        $this->parameterCollection = new ParameterCollection($parameters);
        $this->connection = $connection;
    }

    /**
     * @return string
     */
    public function getSQL()
    {
        return $this->compiledSQL;
    }

    /**
     * @return ParameterCollectionInterface
     */
    public function getParameters()
    {
        return $this->parameterCollection;
    }

    /**
     * @return ConnectionInterface|null
     */
    public function getConnection()
    {
        return $this->connection;
    }

    /**
     * @param int|string $name
     * @param mixed      $value
     *
     * @return $this
     */
    public function setParameter($name, $value)
    {
        $this->getParameters()->setValue($name, $value);

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function prepare()
    {
        $stmt = $this->connection->prepare($this->getSQL());

        foreach ($this->getParameters()->toArray() as $parameter) {
            $stmt->bindValue($parameter->getName(), $parameter->getValue());
        }

        return $stmt;
    }

    /**
     * @inheritdoc
     */
    public function execute()
    {
        $stmt = $this->prepare();
        $stmt->execute();

        return $stmt;
    }
}