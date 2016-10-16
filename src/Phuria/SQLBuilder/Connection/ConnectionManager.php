<?php

/**
 * This file is part of Phuria SQL Builder package.
 *
 * Copyright (c) 2016 Beniamin Jonatan Šimko
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Phuria\SQLBuilder\Connection;

/**
 * @author Beniamin Jonatan Šimko <spam@simko.it>
 */
class ConnectionManager implements ConnectionManagerInterface
{
    /**
     * @var array
     */
    private $connections = [];

    /**
     * @inheritdoc
     */
    public function registerConnection(ConnectionInterface $connection, $name = 'default')
    {
        $this->connections[$name] = $connection;
    }

    /**
     * @inheritdoc
     */
    public function getConnection($name = null)
    {
        if (0 === count($this->connections)) {
            return new NullConnection();
        }

        return $name ? $this->connections[$name] : reset($this->connections);
    }
}