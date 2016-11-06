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

use Phuria\UnderQuery\Statement\PDOStatement;

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
     * @inheritdoc
     */
    public function prepareStatement($SQL, $parameters = [])
    {
        $stmt = $this->wrappedConnection->prepare($SQL);
        $wrappedStatement = new PDOStatement($stmt);

        if ($parameters) {
            $wrappedStatement->bindParameters($parameters);
        }

        return $wrappedStatement;
    }
}