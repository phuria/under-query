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

use Phuria\SQLBuilder\Exception\ConnectionException;

/**
 * @author Beniamin Jonatan Šimko <spam@simko.it>
 */
interface ConnectionManagerInterface
{
    /**
     * @param ConnectionInterface $connection
     * @param string              $name
     *
     * @return void
     */
    public function registerConnection(ConnectionInterface $connection, $name = 'default');

    /**
     * @param string $name
     *
     * @return bool
     */
    public function hasConnection($name);

    /**
     * @param string|null $name
     *
     * @return ConnectionInterface
     * @throws ConnectionException
     */
    public function getConnection($name = 'default');
}