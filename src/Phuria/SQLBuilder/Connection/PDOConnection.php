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

use Phuria\SQLBuilder\Statement\PDOStatement;

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
     * @inheritdoc
     */
    public function query($SQL)
    {
        $stmt = $this->wrappedConnection->query($SQL);

        return new PDOStatement($stmt);
    }

    /**
     * @inheritdoc
     */
    public function prepare($SQL)
    {
        $stmt = $this->wrappedConnection->prepare($SQL);

        return new PDOStatement($stmt);
    }
}