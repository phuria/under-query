<?php

/**
 * This file is part of Phuria SQL Builder package.
 *
 * Copyright (c) 2016 Beniamin Jonatan Šimko
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Phuria\SQLBuilder\Statement;

/**
 * @author Beniamin Jonatan Šimko <spam@simko.it>
 */
class PDOStatement implements StatementInterface
{
    /**
     * @var \PDOStatement $wrappedStatement
     */
    private $wrappedStatement;

    /**
     * @param \PDOStatement $statement
     */
    public function __construct(\PDOStatement $statement)
    {
        $this->wrappedStatement = $statement;
    }

    /**
     * @inheritdoc
     */
    public function bindValue($parameter, $value)
    {
        $this->wrappedStatement->bindValue($parameter, $value);

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function rowCount()
    {
        return $this->wrappedStatement->rowCount();
    }

    /**
     * @inheritdoc
     */
    public function execute()
    {
        $this->wrappedStatement->execute();

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function fetchScalar()
    {
        if (0 === $this->rowCount()) {
            return null;
        }

        return $this->wrappedStatement->fetch(\PDO::FETCH_COLUMN);
    }
}