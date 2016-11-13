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

use Phuria\UnderQuery\Connection\ConnectionInterface;
use Phuria\UnderQuery\Parameter\ParameterCollection;
use Phuria\UnderQuery\Parameter\ParameterCollectionInterface;
use Phuria\UnderQuery\Statement\StatementInterface;

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
     * @return StatementInterface
     */
    public function prepareStatement()
    {
        return $this->connection->prepareStatement($this->getSQL(), $this->getParameters()->toArray());
    }
}