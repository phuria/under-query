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

use Phuria\UnderQuery\Parameter\QueryParameterInterface;

/**
 * @author Beniamin Jonatan Šimko <spam@simko.it>
 */
class PDOConnection implements ConnectionInterface
{
    /**
     * @var \PDO $wrappedConnection
     */
    private $wrappedConnection;

    /**
     * @param \PDO $connection
     */
    public function __construct(\PDO $connection)
    {
        $this->wrappedConnection = $connection;
    }

    /**
     * @return \PDO
     */
    public function getWrappedConnection()
    {
        return $this->wrappedConnection;
    }

    /**
     * @param $SQL
     *
     * @return \PDOStatement
     */
    public function prepareStatement($SQL)
    {
        return $this->wrappedConnection->prepare($SQL);
    }
}