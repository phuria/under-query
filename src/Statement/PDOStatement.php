<?php

/**
 * This file is part of UnderQuery package.
 *
 * Copyright (c) 2016 Beniamin Jonatan Šimko
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Phuria\UnderQuery\Statement;

/**
 * @author Beniamin Jonatan Šimko <spam@simko.it>
 */
class PDOStatement implements StatementInterface
{
    /**
     * @var \PDOStatement
     */
    private $wrappedStatement;

    /**
     * @param \PDOStatement $stmt
     */
    public function __construct(\PDOStatement $stmt)
    {
        $this->wrappedStatement = $stmt;
    }

    /**
     * @return \PDOStatement
     */
    public function getWrappedStatement()
    {
        return $this->wrappedStatement;
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
    public function rowCount()
    {
        return $this->wrappedStatement->rowCount();
    }
}