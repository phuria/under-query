<?php

/**
 * This file is part of UnderQuery package.
 *
 * Copyright (c) 2016 Beniamin Jonatan Šimko
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Phuria\UnderQuery\Connection;

use Phuria\UnderQuery\Exception\ConnectionException;

/**
 * @author Beniamin Jonatan Šimko <spam@simko.it>
 */
class ConnectionManager implements ConnectionManagerInterface
{
    const DEFAULT_CONNECTION_NAME = 'default';

    /**
     * @var array
     */
    private $connections = [];

    /**
     * @inheritdoc
     */
    public function registerConnection(ConnectionInterface $connection, $name = self::DEFAULT_CONNECTION_NAME)
    {
        $this->connections[$name] = $connection;
    }

    /**
     * @inheritdoc
     */
    public function hasConnection($name)
    {
        return array_key_exists($name, $this->connections);
    }

    /**
     * @inheritdoc
     */
    public function getConnection($name = self::DEFAULT_CONNECTION_NAME)
    {
        if (false === $this->hasConnection($name)) {
            throw ConnectionException::notRegistered($name);
        }

        return $this->connections[$name];
    }

    /**
     * @inheritdoc
     */
    public function prepareStatement(
        $compiledSQL,
        array $parameters = [],
        $connectionHint = self::DEFAULT_CONNECTION_NAME
    ) {
        $connection = $this->getConnection($connectionHint);
        $preparedStatement = $connection->prepareStatement($compiledSQL, $parameters);

        return $preparedStatement;
    }
}